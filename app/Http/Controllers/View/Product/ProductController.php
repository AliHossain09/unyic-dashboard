<?php

namespace App\Http\Controllers\View\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = (int) $request->input('perPage', 10); // default 10 per page

        // build query and eager load relations (including images if you use them)
        $query = Product::with(['category', 'subCategory', 'images']);

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
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

        return view('admin.product.index', compact('products'));
    }

    // department_id
    public function create()
    {
        $categories = Category::with('subCategories')->get();
        $subCategories = SubCategory::all();
        $sizes = Size::all();
        $collections = Collection::all(); // <-- send collections to view

        return view('admin.product.create', compact('categories', 'sizes', 'collections', 'subCategories'));
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

        $slug = Str::slug($validated['name']);
        $count = Product::where('slug', 'LIKE', "{$slug}%")->count();
        $slug = $count ? "{$slug}-{$count}" : $slug;

        // Product তৈরি
        $product = Product::create([
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
            'brand' => $validated['brand'] ?? null,
            'discount_percent' => $validated['discount_percent'] ?? null,

            'slug' => $slug,
        ]);

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

        // load relations needed in the form (images, sizes, collections, subCategory)
        $product->load(['images', 'sizes', 'collections', 'subCategory']);

        return view('admin.product.edit', compact('product', 'categories', 'sizes', 'collections'));
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

        // Update product fields
        $product->update([
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
            'brand' => $validated['brand'] ?? null,
            'discount_percent' => $validated['discount_percent'] ?? null,
        ]);

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

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();

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
