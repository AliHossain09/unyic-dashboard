<?php

namespace App\Http\Controllers\View\Wishlist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
     public function index(Request $request)
    {
        return Wishlist::with('product')->where('user_id', $request->user()->id)->get();
    }

    public function store(Request $request)
    {
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
        ]);

        return response()->json($wishlist, 201);
    }

    public function destroy(Request $request, $id)
    {
        $wishlist = Wishlist::where('user_id', $request->user()->id)->findOrFail($id);
        $wishlist->delete();
        return response()->json(['message' => 'Removed from wishlist']);
    }
}
