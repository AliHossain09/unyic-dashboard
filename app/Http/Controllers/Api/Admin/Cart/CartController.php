<?php

namespace App\Http\Controllers\Api\Admin\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['user', 'product'])->latest()->get();
        return view('admin.cart.index', compact('carts'));
    }

    public function destroy(Request $request, $id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return redirect()->back()->with('error', 'Cart item not found.');
        }

        $cart->delete();
        return redirect()->back()->with('success', 'Cart item deleted successfully.');
    }
}
