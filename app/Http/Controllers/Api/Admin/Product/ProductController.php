<?php

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Size;
use App\Support\FrontendProductCache;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()   // optional
    {
        $products = Product::with(['category', 'subCategory', 'sizes'])->get();

        // return response()->json($products);
        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'sizes' => 'nullable|array',
            'collections' => 'nullable|array',
            'collections.*' => 'exists:collections,id',
            'is_popular' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'old_price' => 'nullable|numeric',
            'brand' => 'nullable|string|max:255',
            'collection' => 'nullable|string|max:255',
            'discount_percent' => 'nullable|numeric',
            'color' => 'nullable|string|max:255',
            'disclaimer' => 'nullable|string',
            'careInstructions' => 'nullable|string',
            'countryOfOrigin' => 'nullable|string|max:255',
            'manufactureDate' => 'nullable|date',
            'netQuantity' => 'nullable|integer',
        ]);

        $slug = Str::slug($validated['name']);
        $count = Product::where('slug', 'LIKE', "{$slug}%")->count();
        $slug = $count ? "{$slug}-{$count}" : $slug;

        $productData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'sub_category_id' => $validated['sub_category_id'],
            'is_popular' => $validated['is_popular'] ?? false,
            'is_new' => $validated['is_new'] ?? false,
            'old_price' => $validated['old_price'] ?? null,
            'brand' => $validated['brand'] ?? null,
            'collection' => $validated['collection'] ?? null,
            'discount_percent' => $validated['discount_percent'] ?? null,
            'color' => $validated['color'] ?? null,
            'disclaimer' => $validated['disclaimer'] ?? null,
            'care_instructions' => $validated['careInstructions'] ?? null,
            'country_of_origin' => $validated['countryOfOrigin'] ?? null,
            'manufacture_date' => $validated['manufactureDate'] ?? null,
            'net_quantity' => $validated['netQuantity'] ?? null,
            'slug' => $slug,
        ];

        $product = Product::create($productData);

        if (! empty($validated['sizes'])) {
            $product->sizes()->sync($validated['sizes']);
        }

        if (! empty($validated['collections'])) {
            $product->collections()->sync($validated['collections']);
        }

        FrontendProductCache::bump();

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product->fresh(['category', 'subCategory', 'sizes'])),
        ], 201);
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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'sizes' => 'nullable|array',
            'collections' => 'nullable|array',
            'collections.*' => 'exists:collections,id',
            'is_popular' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'old_price' => 'nullable|numeric',
            'brand' => 'nullable|string|max:255',
            'collection' => 'nullable|string|max:255',
            'discount_percent' => 'nullable|numeric',
            'color' => 'nullable|string|max:255',
            'disclaimer' => 'nullable|string',
            'careInstructions' => 'nullable|string',
            'countryOfOrigin' => 'nullable|string|max:255',
            'manufactureDate' => 'nullable|date',
            'netQuantity' => 'nullable|integer',
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'sub_category_id' => $validated['sub_category_id'],
            'is_popular' => $validated['is_popular'] ?? false,
            'is_new' => $validated['is_new'] ?? false,
            'net_quantity' => $validated['netQuantity'] ?? null,
            'manufacture_date' => $validated['manufactureDate'] ?? null,
            'country_of_origin' => $validated['countryOfOrigin'] ?? null,
            'care_instructions' => $validated['careInstructions'] ?? null,
            'disclaimer' => $validated['disclaimer'] ?? null,
            'color' => $validated['color'] ?? null,
            'collection' => $validated['collection'] ?? null,
            'old_price' => $validated['old_price'] ?? null,
            'brand' => $validated['brand'] ?? null,
            'discount_percent' => $validated['discount_percent'] ?? null,
        ]);

        if (! empty($validated['sizes'])) {
            $product->sizes()->sync($validated['sizes']);
        }

        if (! empty($validated['collections'])) {
            $product->collections()->sync($validated['collections']);
        }

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
