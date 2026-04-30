<?php

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Size;
use App\Support\FrontendProductCache;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()   // optional
    {
        $products = Product::with(['category', 'subCategory', 'sizes'])->get();

        // return response()->json($products);
        return ProductResource::collection($products);
    }

    public function show($value)
    {
        $product = Product::with(['category', 'subCategory', 'sizes'])
            ->where(function ($query) use ($value) {
                $query->where('id', $value)
                    ->orWhere('slug', $value);
            })
            ->firstOrFail();

        $product->increment('views'); // view count update

        // Single product as object (no array)
        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
        ], 200);
    }

    public function popular()
    {
        $products = Product::where('is_popular', true)
            ->with(['category', 'subCategory'])
            ->take(12)
            ->get();

        return response()->json($products);
    }

    public function newArrivals()
    {
        $products = Product::where('is_new', true)
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        return response()->json($products);
    }

    public function mostViewed()
    {
        $products = Product::orderBy('views', 'desc')
            ->take(12)
            ->get();

        return response()->json($products);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'sizes' => 'required|array', // size_id => quantity
            'collections' => 'nullable|array',
            'collections.*' => 'exists:collections,id',
            'is_popular' => 'nullable',
            'is_new' => 'nullable',
            'old_price' => 'nullable',
            'brand' => 'nullable',
            'collection' => 'nullable',
            'discount_percent' => 'nullable',
            'color' => 'nullable',
            'disclaimer' => 'nullable',
            'careInstructions' => 'nullable',
            'countryOfOrigin' => 'nullable',
            'manufactureDate' => 'nullable',
            'netQuantity' => 'nullable',
        ]);

        $product->update([
            // 'name' => $request->name
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'sub_category_id' => $validated['sub_category_id'],
            'is_popular' => isset($validated['is_popular']),
            'is_new' => isset($validated['is_new']),
            'net_quantity' => $validated['netQuantity'],
            'manufacture_date' => $validated['manufactureDate'],
            'country_of_origin' => $validated['countryOfOrigin'],
            'care_instructions' => $validated['careInstructions'],
            'disclaimer' => $validated['disclaimer'],
            'color' => $validated['color'],
            'collection' => $validated['collection'],
            'old_price' => $validated['old_price'],
            'brand' => $validated['brand'],
            'discount_percent' => $validated['discount_percent'],

        ]);
        FrontendProductCache::bump();

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        FrontendProductCache::bump();

        return response()->json([
            'message' => 'Product deleted successfully',
        ]);
    }
}
