<?php

namespace App\Http\Controllers\Api\Frontend\Wishlist;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use App\Support\GuestCookie;
use App\Support\ProductAvailability;
use App\Support\ShoppingIdentity;
use App\Support\ShoppingScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $identity = ShoppingIdentity::resolve($request);

        $wishlistItems = ShoppingScope::apply(Wishlist::with('product')->latest(), $identity)->get();

        $wishlistItems->transform(function (Wishlist $item) {
            return $this->appendAvailability($item);
        });

        ShoppingScope::touchGuestItems(Wishlist::class, $identity);

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'is_guest' => $identity['type'] === 'guest',
            'data' => $wishlistItems,
        ]));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'exists:products,id'],
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

        $wishlistItem = ShoppingScope::apply(
            Wishlist::query()->where('product_id', $product->id),
            $identity
        )->first();

        if ($wishlistItem) {
            $wishlistItem->fill(ShoppingScope::guestActivityPayload($identity));
            $wishlistItem->save();

            return $this->withGuestCookie($identity, response()->json([
                'success' => true,
                'message' => 'Product already exists in wishlist.',
                'data' => $this->appendAvailability($wishlistItem->load('product')),
            ]));
        }

        $wishlistItem = Wishlist::create([
            'user_id' => $identity['user_id'],
            'guest_token' => $identity['guest_token'],
            'product_id' => $product->id,
            ...ShoppingScope::guestActivityPayload($identity),
        ]);

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'message' => 'Product added to wishlist successfully.',
            'data' => $this->appendAvailability($wishlistItem->load('product')),
        ]));
    }

    public function destroy(Request $request, ?int $productId = null)
    {
        $identity = ShoppingIdentity::resolve($request);

        $query = ShoppingScope::apply(Wishlist::query(), $identity);

        if ($productId !== null) {
            $wishlistItem = (clone $query)->where('product_id', $productId)->first();

            if (! $wishlistItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wishlist item not found.',
                ], 404);
            }

            $wishlistItem->delete();
            $message = 'Product removed from wishlist successfully.';
        } else {
            $query->delete();
            $message = 'Wishlist cleared successfully.';
        }

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'message' => $message,
        ]));
    }

    protected function appendAvailability(Wishlist $wishlistItem): Wishlist
    {
        $availability = ProductAvailability::fromProduct($wishlistItem->product);

        $wishlistItem->setAttribute('is_available', $availability['is_available']);
        $wishlistItem->setAttribute('stock_status', $availability['stock_status']);

        return $wishlistItem;
    }

    protected function withGuestCookie(array $identity, $response)
    {
        if ($identity['type'] === 'guest' && $identity['guest_token']) {
            $response->cookie(GuestCookie::make($identity['guest_token']));
        }

        return $response;
    }
}
