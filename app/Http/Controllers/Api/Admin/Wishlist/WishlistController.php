<?php

namespace App\Http\Controllers\Api\Admin\Wishlist;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    /**
     * সব wishlist দেখাবে (user + product সহ)
     */
   public function index()
{
    $wishlists = Wishlist::with(['user', 'product'])->latest()->get();
    // dd($wishlists); //  Check what's coming
    return view('admin.wishlist.index', compact('wishlists'));
}



public function store(Request $request)
{
    if (!$request->user()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized. Please login first.',
        ], 401);
    }

    $wishlist = Wishlist::firstOrCreate([
        'user_id' => $request->user()->id,
        'product_id' => $request->product_id,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Product added to wishlist successfully.',
        'data' => $wishlist
    ], 201);
}



    /**
     * wishlist item delete করবে
     */

    public function destroy(Request $request, $id)
{
    if (!$request->user()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized. Please login first.',
        ], 401);
    }

    $wishlist = Wishlist::where('user_id', $request->user()->id)
                        ->where('id', $id)
                        ->first();

    if (!$wishlist) {
        return response()->json([
            'success' => false,
            'message' => 'Wishlist item not found or not authorized to delete.',
        ], 404);
    }

    $wishlist->delete();

    return response()->json([
        'success' => true,
        'message' => 'Wishlist deleted successfully.'
    ]);
}





    // public function destroy($id)
    // {
    //     $wishlist = Wishlist::findOrFail($id);
    //     $wishlist->delete();

    //     // return response()->json([
    //     //     'success' => true,
    //     //     'message' => 'Wishlist item deleted successfully'
    //     // ]);

    //     return redirect()->back()->with('success', 'Wishlist deleted successfully!');
    // }
}
