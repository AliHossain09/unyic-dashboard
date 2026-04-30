<?php

namespace App\Http\Controllers\View\Product;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use App\Support\FrontendProductCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private function resolveStatusPayload(Request $request, bool $hasIsPublishedColumn, bool $hasPublishAtColumn): array
    {
        $status = strtolower((string) $request->input('status', 'publish'));
        $publishAt = $request->input('publish_at');

        $payload = [];

        if ($hasIsPublishedColumn) {
            $payload['is_published'] = $status === 'publish';
        }

        if ($hasPublishAtColumn) {
            $payload['publish_at'] = $status === 'scheduled' ? ($publishAt ?: null) : null;
        }

        return $payload;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');
        $stock = $request->input('stock');
        $status = strtolower((string) $request->input('status', ''));
        $perPage = (int) $request->input('perPage', 10); // default 10 per page
        $hasStockColumn = Schema::hasColumn('products', 'is_in_stock');
        $hasIsPublishedColumn = Schema::hasColumn('products', 'is_published');
        $hasPublishAtColumn = Schema::hasColumn('products', 'publish_at');

        // build query and eager load relations (including images if you use them)
        $query = Product::with(['category', 'subCategory', 'images']);

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($stock === 'in_stock') {
            if ($hasStockColumn) {
                $query->where('is_in_stock', true);
            } else {
                $query->where('net_quantity', '>', 0);
            }
        } elseif ($stock === 'out_of_stock') {
            if ($hasStockColumn) {
                $query->where('is_in_stock', false);
            } else {
                $query->where(function ($q) {
                    $q->where('net_quantity', '=', 0)->orWhereNull('net_quantity');
                });
            }
        }

        if ($status === 'publish') {
            if ($hasIsPublishedColumn) {
                $query->where('is_published', true);
            } else {
                $query->where(function ($q) {
                    $q->where('is_popular', true)->orWhere('is_new', true);
                });
            }
        } elseif ($status === 'inactive') {
            if ($hasIsPublishedColumn) {
                $query->where('is_published', false);
            } else {
                $query->where('is_popular', false)->where('is_new', false);
            }
        } elseif ($status === 'scheduled') {
            if ($hasPublishAtColumn) {
                $query->where('publish_at', '>', now());
            } else {
                // No schedule field in DB yet, return empty until schema supports it.
                $query->whereRaw('1 = 0');
            }
        }

        // ============ EXPORT LOGIC ============
        if ($request->filled('export_ids')) {
            $exportIds = (array) $request->input('export_ids');

            $exportData = Product::with(['category', 'subCategory'])
                ->whereIn('id', $exportIds)
                ->orderBy('name')
                ->get();

            $filename = 'products_export_'.date('Ymd_His').'.csv';

            $callback = function () use ($exportData) {
                $handle = fopen('php://output', 'w');
                // CSV header
                fputcsv($handle, ['ID', 'Name', 'Category', 'SubCategory', 'Price', 'Old Price', 'Created At']);

                foreach ($exportData as $p) {
                    fputcsv($handle, [
                        $p->id,
                        $p->name,
                        optional($p->category)->name,
                        optional($p->subCategory)->name,
                        $p->price,
                        $p->old_price,
                        $p->created_at ? $p->created_at->format('Y-m-d H:i:s') : '',
                    ]);
                }

                fclose($handle);
            };

            return response()->streamDownload($callback, $filename, [
                'Content-Type' => 'text/csv',
            ]);
        }
        // =======================================

        // paginate and keep query string so filters persist
        $products = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        $categories = Category::all();

        return view('admin.product.index', compact('products', 'categories', 'hasStockColumn'));
    }

    public function updateStock(Request $request, Product $product)
    {
        if (! Schema::hasColumn('products', 'is_in_stock')) {
            return response()->json([
                'success' => false,
                'message' => 'Stock column not found. Please run migrations.',
            ], 422);
        }

        $validated = $request->validate([
            'is_in_stock' => ['required', 'boolean'],
        ]);

        $product->update([
            'is_in_stock' => (bool) $validated['is_in_stock'],
        ]);
        FrontendProductCache::bump();

        return response()->json([
            'success' => true,
            'message' => 'Stock status updated successfully.',
            'data' => [
                'id' => $product->id,
                'is_in_stock' => (bool) $product->is_in_stock,
            ],
        ]);
    }

    // department_id
    public function create()
    {
        $categories = Category::with('subCategories')->get();
        $subCategories = SubCategory::all();
        $sizes = Size::all();
        $collections = Collection::all(); // <-- send collections to view
        $brands = Brand::orderBy('name')->get();
        $hasIsPublishedColumn = Schema::hasColumn('products', 'is_published');
        $hasPublishAtColumn = Schema::hasColumn('products', 'publish_at');

        return view('admin.product.create', compact('categories', 'sizes', 'collections', 'subCategories', 'brands', 'hasIsPublishedColumn', 'hasPublishAtColumn'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
            'brand_id' => 'nullable|exists:brands,id',
            'brand_name' => 'nullable|string|max:255',
            'collection' => 'nullable',
            'discount_percent' => 'nullable',
            'color' => 'nullable',
            'disclaimer' => 'nullable',
            'careInstructions' => 'nullable',
            'countryOfOrigin' => 'nullable',
            'manufactureDate' => 'nullable',
            'netQuantity' => 'nullable',
            'status' => 'nullable|in:publish,scheduled,inactive',
            'publish_at' => 'nullable|date',
        ]);

        $slug = Str::slug($validated['name']);
        $count = Product::where('slug', 'LIKE', "{$slug}%")->count();
        $slug = $count ? "{$slug}-{$count}" : $slug;

        // Product তৈরি
        $hasIsPublishedColumn = Schema::hasColumn('products', 'is_published');
        $hasPublishAtColumn = Schema::hasColumn('products', 'publish_at');

        $brandName = null;
        $brandId = null;

        if (! empty($validated['brand_id'])) {
            $brand = Brand::find($validated['brand_id']);
            if ($brand) {
                $brandName = $brand->name;
                $brandId = $brand->id;
            }
        } elseif (! empty($validated['brand_name'])) {
            $brandName = trim($validated['brand_name']);
            $brandSlug = Str::slug($brandName);
            $brand = Brand::firstOrCreate([
                'slug' => $brandSlug,
            ], [
                'name' => $brandName,
            ]);
            $brandId = $brand->id;
            $brandName = $brand->name;
        }

        $productData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'sub_category_id' => $validated['sub_category_id'],
            'is_popular' => isset($validated['is_popular']) ? 1 : 0,
            'is_new' => isset($validated['is_new']) ? 1 : 0,
            'net_quantity' => $validated['netQuantity'] ?? null,
            'manufacture_date' => $validated['manufactureDate'] ?? null,
            'country_of_origin' => $validated['countryOfOrigin'] ?? null,
            'care_instructions' => $validated['careInstructions'] ?? null,
            'disclaimer' => $validated['disclaimer'] ?? null,
            'color' => $validated['color'] ?? null,
            'collection' => $validated['collection'] ?? null,
            'old_price' => $validated['old_price'] ?? null,
            'brand' => $brandName,
            'brand_id' => $brandId,
            'discount_percent' => $validated['discount_percent'] ?? null,

            'slug' => $slug,
        ];

        $productData = array_merge($productData, $this->resolveStatusPayload($request, $hasIsPublishedColumn, $hasPublishAtColumn));

        $product = Product::create($productData);

        // // সাইজ attach
        // foreach ($validated['sizes'] as $sizeId => $qty) {
        //     $product->sizes()->attach($sizeId, ['quantity' => $qty]);
        // }

        // attach sizes with quantity
        foreach ($validated['sizes'] as $sizeId => $qty) {
            if ((int) $qty > 0) {
                $product->sizes()->attach($sizeId, ['quantity' => (int) $qty]);
            }
        }

        // sync collections if provided
        if (! empty($validated['collections'])) {
            $product->collections()->sync($validated['collections']);
        }

        // 4. Multiple Images Upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                // $filename = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $filename = Str::slug($request->name).'_'.time().'_'.uniqid().'.'.$imageFile->getClientOriginalExtension();
                // $filename = $request->name . '_'. time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $path = $imageFile->storeAs('products', $filename, 'public');

                $product->images()->create([
                    'image' => $path,
                    'is_default' => $index === 0, // first image = mother image
                    // 'url' => asset('storage/' . $image->image),
                    // 'isDefault' => $image->is_default,

                ]);
            }
        }
        FrontendProductCache::bump();

        return redirect()->route('products.index')->with('success', 'Product created successfully with sizes!');
    }

    // Show single product
    public function show(Product $product)
    {
        $product->load(['images', 'sizes', 'collections']);

        return view('admin.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::with('subCategories')->get();
        $sizes = Size::all();
        $collections = Collection::all();
        $brands = Brand::orderBy('name')->get();
        $hasIsPublishedColumn = Schema::hasColumn('products', 'is_published');
        $hasPublishAtColumn = Schema::hasColumn('products', 'publish_at');

        // load relations needed in the form (images, sizes, collections, subCategory)
        $product->load(['images', 'sizes', 'collections', 'subCategory']);

        return view('admin.product.edit', compact('product', 'categories', 'sizes', 'collections', 'brands', 'hasIsPublishedColumn', 'hasPublishAtColumn'));
    }

    // Update Product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'sizes' => 'required|array',
            'collections' => 'nullable|array',
            'collections.*' => 'exists:collections,id',
            'is_popular' => 'nullable',
            'is_new' => 'nullable',
            'old_price' => 'nullable',
            'brand_id' => 'nullable|exists:brands,id',
            'brand_name' => 'nullable|string|max:255',
            'collection' => 'nullable',
            'discount_percent' => 'nullable',
            'color' => 'nullable',
            'disclaimer' => 'nullable',
            'careInstructions' => 'nullable',
            'countryOfOrigin' => 'nullable',
            'manufactureDate' => 'nullable',
            'netQuantity' => 'nullable',
            'status' => 'nullable|in:publish,scheduled,inactive',
            'publish_at' => 'nullable|date',
        ]);

        // Update product fields
        $brandName = null;
        $brandId = null;

        if (! empty($validated['brand_id'])) {
            $brand = Brand::find($validated['brand_id']);
            if ($brand) {
                $brandName = $brand->name;
                $brandId = $brand->id;
            }
        } elseif (! empty($validated['brand_name'])) {
            $brandName = trim($validated['brand_name']);
            $brandSlug = Str::slug($brandName);
            $brand = Brand::firstOrCreate([
                'slug' => $brandSlug,
            ], [
                'name' => $brandName,
            ]);
            $brandId = $brand->id;
            $brandName = $brand->name;
        }

        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'sub_category_id' => $validated['sub_category_id'],
            'is_popular' => isset($validated['is_popular']) ? 1 : 0,
            'is_new' => isset($validated['is_new']) ? 1 : 0,
            'net_quantity' => $validated['netQuantity'] ?? null,
            'manufacture_date' => $validated['manufactureDate'] ?? null,
            'country_of_origin' => $validated['countryOfOrigin'] ?? null,
            'care_instructions' => $validated['careInstructions'] ?? null,
            'disclaimer' => $validated['disclaimer'] ?? null,
            'color' => $validated['color'] ?? null,
            'collection' => $validated['collection'] ?? null,
            'old_price' => $validated['old_price'] ?? null,
            'brand' => $brandName,
            'brand_id' => $brandId,
            'discount_percent' => $validated['discount_percent'] ?? null,
        ];

        $hasIsPublishedColumn = Schema::hasColumn('products', 'is_published');
        $hasPublishAtColumn = Schema::hasColumn('products', 'publish_at');
        $updateData = array_merge($updateData, $this->resolveStatusPayload($request, $hasIsPublishedColumn, $hasPublishAtColumn));

        $product->update($updateData);

        // Sync sizes with quantity
        $sizeData = [];
        foreach ($validated['sizes'] as $sizeId => $qty) {
            if ((int) $qty > 0) {
                $sizeData[$sizeId] = ['quantity' => (int) $qty];
            }
        }
        $product->sizes()->sync($sizeData); // replaces old size data

        // Sync collections if provided
        if (! empty($validated['collections'])) {
            $product->collections()->sync($validated['collections']);
        } else {
            $product->collections()->detach(); // remove all if none sent
        }

        // Optional: Handle image updates
        if ($request->hasFile('images')) {
            // Delete old images if needed
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }

            foreach ($request->file('images') as $index => $imageFile) {
                $filename = time().'_'.uniqid().'.'.$imageFile->getClientOriginalExtension();
                $path = $imageFile->storeAs('products', $filename, 'public');

                $product->images()->create([
                    'image' => $path,
                    'is_default' => $index === 0,
                ]);
            }
        }
        FrontendProductCache::bump();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();
        FrontendProductCache::bump();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    // Export selected products
    public function export(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        $products = Product::whereIn('id', $ids)->get();  // expects comma-separated IDs or array

        $response = new StreamedResponse(function () use ($ids) {
            $out = fopen('php://output', 'w');
            // Header row
            fputcsv($out, ['ID', 'Name', 'Category', 'Price', 'Qty', 'Status']);

            $products = Product::with(['category'])
                ->when($ids, function ($q) use ($ids) {
                    if (is_array($ids)) {
                        $q->whereIn('id', $ids);
                    } else {
                        $arr = explode(',', $ids);
                        $q->whereIn('id', $arr);
                    }
                })
                ->get();

            foreach ($products as $p) {
                fputcsv($out, [
                    $p->id,
                    $p->name,
                    optional($p->category)->name,
                    $p->price,
                    $p->net_quantity,
                    $p->is_published ? 'Published' : 'Inactive',
                ]);
            }

            fclose($out);
        });

        $filename = 'products_export_'.now()->format('Ymd_His').'.csv';

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
}
