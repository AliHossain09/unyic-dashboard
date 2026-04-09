<?php

namespace App\Http\Controllers\Api\Frontend\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\Product;
use App\Support\GuestCookie;
use App\Support\ProductInteractionTracker;
use App\Support\ShoppingIdentity;
use App\Support\ShoppingScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $identity = ShoppingIdentity::resolve($request);

        $cartItems = ShoppingScope::apply(
            Cart::with(['product.images', 'product.sizes'])->latest(),
            $identity
        )->get();

        ShoppingScope::touchGuestItems(Cart::class, $identity);

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'is_guest' => $identity['type'] === 'guest',
            'data' => CartItemResource::collection($cartItems),
        ]));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'size' => ['nullable', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $identity = ShoppingIdentity::resolve($request);
        $product = Product::query()->find($request->integer('product_id'));

        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        $quantity = max(1, (int) ($request->input('quantity') ?: 1));
        $size = $request->input('size');

        $cartItem = ShoppingScope::apply(
            Cart::query()->where('product_id', $product->id)->where('size', $size),
            $identity
        )->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->fill(ShoppingScope::guestActivityPayload($identity));
            $cartItem->save();
        } else {
            $cartItem = Cart::create([
                'user_id' => $identity['user_id'],
                'guest_token' => $identity['guest_token'],
                'product_id' => $product->id,
                'quantity' => $quantity,
                'size' => $size,
                ...ShoppingScope::guestActivityPayload($identity),
            ]);
        }

        ProductInteractionTracker::record($request, $product->id, ProductInteractionTracker::TYPE_CART);

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully.',
            'data' => new CartItemResource($cartItem->load(['product.images', 'product.sizes'])),
        ]));
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => ['required', 'integer', 'min:1'],
            'size' => ['nullable', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $identity = ShoppingIdentity::resolve($request);

        $cartItem = ShoppingScope::apply(Cart::query(), $identity)
            ->where('id', $id)
            ->first();

        if (! $cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.',
            ], 404);
        }

        $newSize = $request->input('size', $cartItem->size);

        $duplicate = ShoppingScope::apply(Cart::query(), $identity)
            ->where('product_id', $cartItem->product_id)
            ->where('size', $newSize)
            ->where('id', '!=', $cartItem->id)
            ->first();

        if ($duplicate) {
            $duplicate->quantity += $request->integer('quantity');
            $duplicate->fill(ShoppingScope::guestActivityPayload($identity));
            $duplicate->save();
            $cartItem->delete();

            $cartItem = $duplicate->load(['product.images', 'product.sizes']);
        } else {
            $cartItem->quantity = $request->integer('quantity');
            $cartItem->size = $newSize;
            $cartItem->fill(ShoppingScope::guestActivityPayload($identity));
            $cartItem->save();
            $cartItem->load(['product.images', 'product.sizes']);
        }

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'message' => 'Cart updated successfully.',
            'data' => new CartItemResource($cartItem),
        ]));
    }

    public function destroy(Request $request, ?int $id = null)
    {
        $identity = ShoppingIdentity::resolve($request);

        $query = ShoppingScope::apply(Cart::query(), $identity);

        if ($id !== null) {
            $cartItem = (clone $query)->where('id', $id)->first();

            if (! $cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found.',
                ], 404);
            }

            $cartItem->delete();
            $message = 'Cart item removed successfully.';
        } else {
            $query->delete();
            $message = 'Cart cleared successfully.';
        }

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'message' => $message,
        ]));
    }

    protected function withGuestCookie(array $identity, $response)
    {
        if ($identity['type'] === 'guest' && $identity['guest_token']) {
            $response->cookie(GuestCookie::make($identity['guest_token']));
        }

        return $response;
    }
}
