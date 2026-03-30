<?php

namespace App\Http\Controllers\Api\Frontend\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
    {
        if (! $request->user()) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthorized. Please login first.',
            ], 401);
        }

        $carts = Cart::with('product.images', 'product.sizes', 'product.category')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        $data = $carts->map(function ($item) {
            return [
                'id' => $item->id,
                'size' => $item->size,
                'quantity' => $item->quantity,
                // 'product' => new ProductResource($item->product),
                'product' => (new ProductResource($item->product))->hideDetails(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        // 1️⃣ Auth check
        $user = $request->user();
        if (! $user) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthenticated. Please login first.',
            ], 401);
        }

        // 2️⃣ Validation
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'size' => 'required|string',
                'quantity' => 'nullable|integer|min:1', // optional but must be >=1 if provided
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        // 3️⃣ Check if product already exists in user's cart (same size)
        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->first();

        if ($cart) {
            // ✅ Increment existing quantity or set specific quantity if provided
            $cart->quantity = $request->quantity ?? ($cart->quantity + 1);
            $cart->save();
        } else {
            // ✅ New cart item, default quantity = 1 if not provided
            $cart = Cart::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'size' => $request->size,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        // 4️⃣ Response
        return response()->json([
            'success' => true,
            'status' => 201,
            'message' => 'Product added/updated in cart successfully',
            'data' => [
                'id' => $cart->id,
                'size' => $cart->size,
                'quantity' => $cart->quantity,
                'product' => new ProductResource($cart->product),
            ],
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // 1. Auth check (same as your original)
        if (! $request->user()) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthenticated. Please login first.',
            ], 401);
        }

        // 2. Validation (same structure as original)
        try {
            $request->validate([
                'size' => 'required|string',
                'quantity' => 'nullable|integer|min:1',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        // 3. Fetch user's cart item
        $cart = Cart::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $newQuantity = $request->quantity ?? $cart->quantity;

        DB::transaction(function () use ($request, $cart, &$newQuantity, $id) {

            // 4. Check if same product+size exists (excluding current)
            $existing = Cart::where('user_id', $request->user()->id)
                ->where('product_id', $cart->product_id)
                ->where('size', $request->size)
                ->where('id', '!=', $id)
                ->first();

            if ($existing) {
                $newQuantity += $existing->quantity;
                $existing->delete();
            }

            // 5. Update current cart item
            $cart->update([
                'size' => $request->size,
                'quantity' => $newQuantity,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'data' => [
                'id' => $cart->id,
                'size' => $cart->size,
                'quantity' => $cart->quantity,
                'product' => new ProductResource($cart->product),
            ],
        ], 200);
    }

    public function destroy(Request $request, $id = null)
    {
        if (! $request->user()) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthenticated. Please login first.',
            ], 401);
        }

        if (! $id) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Cart ID is required',
            ], 400);
        }

        $cart = Cart::where('user_id', $request->user()->id)->find($id);

        if (! $cart) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => 'Cart item not found',
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Product removed from cart successfully',
        ]);
    }
}
