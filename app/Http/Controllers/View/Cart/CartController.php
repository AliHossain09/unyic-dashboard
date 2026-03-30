<?php

namespace App\Http\Controllers\View\Cart;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
     public function index(Request $request)
    {
        return Cart::with('product')->where('user_id', $request->user()->id)->get();
    }

    public function store(Request $request)
    {
        $cart = Cart::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $request->product_id],
            ['quantity' => \DB::raw('quantity + 1')]
        );

        return response()->json($cart, 201);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', $request->user()->id)->findOrFail($id);
        $cart->update(['quantity' => $request->quantity]);
        return response()->json($cart);
    }

    public function destroy(Request $request, $id)
    {
        $cart = Cart::where('user_id', $request->user()->id)->findOrFail($id);
        $cart->delete();
        return response()->json(['message' => 'Removed from cart']);
    }
}
