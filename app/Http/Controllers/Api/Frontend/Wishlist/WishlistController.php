<?php

namespace App\Http\Controllers\Api\Frontend\Wishlist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Http\Resources\ProductResource;

class WishlistController extends Controller
{

     /**
     *  Show all wishlist items for logged-in user
     */
    // public function index(Request $request)
    // {
    //     // Unauthenticated check
    //     if (!$request->user()) {
    //         return response()->json([
    //             'success' => false,
    //             'status'  => 401,
    //             'message' => 'Unauthorized. Please login first.',
    //         ], 401);
    //     }

    //     // Fetch wishlist with product relation
    //     $wishlists = Wishlist::with('product')
    //         ->where('user_id', $request->user()->id)
    //         ->latest()
    //         ->get();

    //     return response()->json([
    //         'success' => true,
    //         'data' => $wishlists
    //     ], 200);
    // }
// ................................................................
//    public function index(Request $request)
// {
//     // ✅ 1. Unauthenticated check
//     if (!$request->user()) {
//         return response()->json([
//             'success' => false,
//             'status'  => 401,
//             'message' => 'Unauthorized. Please login first.',
//         ], 401);
//     }

//     // ✅ 2. Fetch wishlist with product relation (and product images + sizes if exists)
//     $wishlists = Wishlist::with(['product.images', 'product.sizes', 'product.category'])
//         ->where('user_id', $request->user()->id)
//         ->latest()
//         ->get();

//     // ✅ 3. Transform data to custom JSON structure
//     $data = $wishlists->map(function ($item) {
//         $product = $item->product;

//         return [
//             'id'   => $product->id,
//             'slug' => $product->slug,
//             'name' => $product->name,

//             // 🖼️ Product Images
//             'images' => $product->images->map(function ($image) {
//                 return [
//                     'url' => asset('storage/' . $image->image_path),
//                     'isDefault' => $image->is_default ?? 0,
//                 ];
//             }),

//             // 📏 Product Sizes
//             'sizes' => $product->sizes->map(function ($size) {
//                 return [
//                     'size' => $size->name,
//                     'quantity' => $size->pivot->quantity ?? 0, // যদি pivot table থাকে (product_size)
//                 ];
//             }),

//             // 💰 Price details
//             'price' => [
//                 'sellingPrice'    => (float) $product->price,
//                 'originalPrice'   => (float) $product->old_price ?? (float) $product->price,
//                 'discountPercent' => (int) $product->discount_percent ?? 0,
//             ],

//             // 📋 Product Details
//             'details' => [
//                 'description'      => $product->description ?? '',
//                 'category'         => $product->category->name ?? 'Unknown',
//                 'brand'            => $product->brand ?? 'Unknown',
//                 'collection'       => $product->collection ?? 'Default Collection',
//                 'color'            => $product->color ?? '',
//                 'disclaimer'       => $product->disclaimer ?? '',
//                 'careInstructions' => $product->care_instructions ?? '',
//             ],

//             // 🧾 Disclosure Info
//             'disclosure' => [
//                 'mrp'             => (float) $product->old_price ?? (float) $product->price,
//                 'netQuantity'     => $product->net_quantity ?? '1 pc',
//                 'manufactureDate' => $product->manufacture_date ?? 'N/A',
//                 'countryOfOrigin' => $product->country_of_origin ?? 'N/A',
//             ],
//         ];
//     });

//     // ✅ 4. Final response
//     return response()->json([
//         'success' => true,
//         'data'    => $data,
//     ], 200);
// }


public function index(Request $request)
{
    if (!$request->user()) {
        return response()->json([
            'success' => false,
            'status'  => 401,
            'message' => 'Unauthorized. Please login first.',
        ], 401);
    }

    $wishlists = Wishlist::with('product.images', 'product.sizes', 'product.category')->where('user_id', $request->user()->id)->latest()->get();

    //এখন ProductResource ব্যবহার করো
    // $products = $wishlists->map(function ($item) {
    //     return new ProductResource($item->product);
    //     // 'product' => (new ProductResource($item->product))->hideDetails(),
    // });

//     $products = $wishlists->map(function ($item) {
//     return [
//         'product' => (new ProductResource($item->product))->hideDetails(),
//     ];
// });
$products = $wishlists->map(function ($item) {
    return (new ProductResource($item->product))->hideDetails();
});



    return response()->json([
        'success' => true,
        'data'    => $products
        // 'data'    => $wishlists
    ], 200);
}



    /**
     *  Add a product to wishlist
     */
    // public function store(Request $request)
    // {
    //     // Unauthenticated check
    //     if (!$request->user()) {
    //         return response()->json([
    //             'success' => false,
    //             'status'  => 401,
    //             'message' => 'Unauthorized. Please login first.',
    //         ], 401);
    //     }

    //     // Validation
    //     $validated = $request->validate([
    //         'product_id' => 'required|integer|exists:products,id'
    //     ]);

    //     // Create or find wishlist
    //     $wishlist = Wishlist::firstOrCreate([
    //         'user_id' => $request->user()->id,
    //         'product_id' => $validated['product_id'],
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Product added to wishlist successfully.',
    //         'data' => $wishlist
    //     ], 201);
    // }


    public function store(Request $request)
{
    if (!$request->user()) {
        return response()->json([
            'success' => false,
            'status'  => 401,
            'message' => 'Unauthenticated. Please login first.'
        ], 401);
    }

    try {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'status'  => 422,
            'message' => 'Validation failed',
            'errors'  => $e->errors()
        ], 422);
    }

    // Continue normal logic
    $wishlist = Wishlist::firstOrCreate([
        'user_id' => $request->user()->id,
        'product_id' => $request->product_id,
    ]);

    return response()->json([
        'success' => true,
        'status'  => 201,
        'message' => 'Product added to wishlist',
        'data'    => $wishlist
    ], 201);
}




    public function destroy(Request $request, $productId = null)
{
    if (!$request->user()) {
        return response()->json([
            'success' => false,
            'status' => 401,
            'message' => 'Unauthorized. Please login first.'
        ], 401);
    }

    if (!$productId) {
        return response()->json([
            'success' => false,
            'status' => 400,
            'message' => 'Product ID is required to delete wishlist item.'
        ], 400);
    }

    $wishlist = Wishlist::where('user_id', $request->user()->id)
                        ->where('product_id', $productId)
                        ->first();

    if (!$wishlist) {
        return response()->json([
            'success' => false,
            'status' => 404,
            'message' => 'Wishlist item not found or not authorized to delete.'
        ], 404);
    }

    $wishlist->delete();

    return response()->json([
        'success' => true,
        'message' => 'Wishlist deleted successfully.'
    ], 200);
}
































    // ............................................................................................................................................
    // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ...........................................................................................................................................




    /**
     * ইউজারের সব wishlist দেখানো হবে।
     */
    // public function index(Request $request)
    // {
    //     $wishlists = Wishlist::where('user_id', $request->user()->id)
    //         ->with('product')
    //         ->get();

    //     return response()->json([
    //         'success' => true,
    //         'data'    => $wishlists,
    //     ]);
    // }
// .............................................................................................................
//     public function index(Request $request)
// {
//     // ইউজারের wishlist নিয়ে আসা
//     $wishlists = Wishlist::where('user_id', $request->user()->id)
//         ->with([
//             'product.images',   // product এর images relation
//             'product.sizes'     // product এর sizes relation
//         ])
//         ->get();

//     // Response structure
//     $data = $wishlists->map(function($wishlist) {
//         $product = $wishlist->product;

//         if(!$product) return null; // যদি product null হয়

//         return [
//             'id'    => $product->id,
//             'slug'  => $product->slug,
//             'name'  => $product->name,
//             'images'=> $product->images->map(function($img) {
//                 return [
//                     'url' => asset('storage/products/' . $img->filename),
//                     'isDefault' => $img->is_default,
//                 ];
//             }),
//             'sizes' => $product->sizes->map(function($size) {
//                 return [
//                     'size' => $size->size,
//                     'quantity' => $size->quantity,
//                 ];
//             }),
//             'price' => [
//                 'sellingPrice' => $product->selling_price,
//                 'originalPrice'=> $product->original_price,
//                 'discountPercent' => $product->discount_percent,
//             ],
//             'details' => [
//                 'description' => $product->description,
//                 'category'    => $product->category?->name,
//                 'brand'       => $product->brand?->name ?? 'Unknown',
//                 'collection'  => $product->collection ?? 'Default Collection',
//                 'color'       => $product->color ?? 'N/A',
//                 'disclaimer'  => $product->disclaimer ?? '',
//                 'careInstructions' => $product->care_instructions ?? '',
//             ],
//             'disclosure' => [
//                 'mrp' => $product->mrp,
//                 'netQuantity' => $product->net_quantity ?? 'N/A',
//                 'manufactureDate' => $product->manufacture_date ?? 'N/A',
//                 'countryOfOrigin' => $product->country_of_origin ?? 'N/A',
//             ]
//         ];
//     })->filter(); // null values remove করে দেবে

//     return response()->json([
//         'success' => true,
//         'data' => $data,
//     ]);
// }

// ......................................................................................................

    /**
     * wishlist-এ প্রোডাক্ট যোগ করা হবে।
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //     ]);

    //     $wishlist = Wishlist::firstOrCreate([
    //         'user_id'    => $request->user()->id,
    //         'product_id' => $request->product_id,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Product added in wishlist successfully',
    //         'data'    => $wishlist->load('product'),
    //     ], 201);
    // }

// ..............................................................................................................

//     public function store(Request $request)
// {
//     if (!$request->user()) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Unauthorized. Please login first.',
//         ], 401);
//     }

//     $wishlist = Wishlist::firstOrCreate([
//         'user_id' => $request->user()->id,
//         'product_id' => $request->product_id,
//     ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'Product added to wishlist successfully.',
//         'data' => $wishlist
//     ], 201);
// }

// ...............................................................................................................

    /**
     * wishlist থেকে প্রোডাক্ট রিমুভ করা হবে।
     */
    // public function destroy(Request $request, $id)
    // {
    //     $wishlist = Wishlist::where('user_id', $request->user()->id)
    //         ->where('id', $id)
    //         ->firstOrFail();

    //     $wishlist->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Wishlist deleted successfully!',
    //     ]);
    // }


// ...................................................................................

//     public function destroy(Request $request, $id)
// {
//     if (!$request->user()) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Unauthorized. Please login first.',
//         ], 401);
//     }

//     $wishlist = Wishlist::where('user_id', $request->user()->id)
//                         ->where('id', $id)
//                         ->first();

//     if (!$wishlist) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Wishlist item not found or not authorized to delete.',
//         ], 404);
//     }

//     $wishlist->delete();

//     return response()->json([
//         'success' => true,
//         'message' => 'Wishlist deleted successfully.'
//     ]);
// }
// ....................................................................

//     public function destroy(Request $request, $productId)
// {
//     $wishlist = Wishlist::where('user_id', $request->user()->id)
//         ->where('product_id', $productId)
//         ->first();

//     if (!$wishlist) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Product not found in your wishlist',
//         ], 404);
//     }

//     $wishlist->delete();

//     return response()->json([
//         'success' => true,
//         'message' => 'Product removed from wishlist successfully',
//     ]);
// }

}
