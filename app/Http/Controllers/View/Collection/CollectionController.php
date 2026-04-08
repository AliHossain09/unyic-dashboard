<?php

namespace App\Http\Controllers\View\Collection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CollectionController extends Controller
{

    //   public function index()
    // {
    //     $collections = Collection::all();
    //     return view('admin.collection.index', compact('collections'));
    // }

public function index(Request $request)
{
    $search = $request->input('search');
    $perPage = (int) $request->input('perPage', $request->input('per_page', 10)); // backward compatible
    if (! in_array($perPage, [10, 25, 50], true)) {
        $perPage = 10;
    }

    $query = Collection::query();

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('brand', 'like', "%{$search}%")
              ->orWhere('short_description', 'like', "%{$search}%")
              ->orWhere('banner_image', 'like', "%{$search}%");
        });
    }

    // ================= EXPORT LOGIC =================
    if ($request->has('export_ids')) {
        $exportIds = $request->get('export_ids'); // array of selected IDs
        $exportData = Collection::whereIn('id', $exportIds)
                                ->orderBy('title')->orderBy('description')->orderBy('banner_image')
                                ->get();

        $filename = 'collections_export_'.date('Ymd_His').'.csv';

        $response = new StreamedResponse(function() use ($exportData) {
            $handle = fopen('php://output', 'w');

            // CSV header
            fputcsv($handle, ['ID', 'Name', 'Brand', 'Short Description', 'Description', 'Banner Image', 'Featured', 'Created At']);

            // Data rows
            foreach ($exportData as $collection) {
                fputcsv($handle, [
                    $collection->id,
                    $collection->title,
                    $collection->brand,
                    $collection->short_description,
                    $collection->description,
                    $collection->banner_image,
                    $collection->is_featured ? 'Yes' : 'No',
                    $collection->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
    // =================================================

    $collections = $query->orderBy('title')->orderBy('description')->orderBy('banner_image')
                         ->paginate($perPage)
                         ->withQueryString();

    return view('admin.collection.index', compact('collections'));
}


    public function create()
    {
        return view('admin.collection.create');
    }




    public function store(Request $request)
{
    // 1. Validation
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'brand' => 'nullable|string|max:255',
        'short_description' => 'nullable|string|max:255',
        'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'is_featured' => 'nullable|boolean',
    ]);

    $imagePath = null;

    if ($request->hasFile('banner_image')) {
        $image = $request->file('banner_image');

        // original extension
        $extension = $image->getClientOriginalExtension();

        // clean title (replace spaces with underscores)
        $title = preg_replace('/\s+/', '_', $request->title);

        // new filename: title.timestamp.extension
        $filename = $title . '_' . time() . '.' . $extension;

        // save to collections folder inside public disk
        $imagePath = $image->storeAs('collections', $filename, 'public');
    }

    Collection::create([
        'title' => $request->title,
        'description' => $request->description,
        'brand' => $request->brand,
        'short_description' => $request->short_description,
        'banner_image' => $imagePath,
        'is_featured' => $request->boolean('is_featured', true),
    ]);

    return redirect()->route('collections.index')->with('success', 'Collection created successfully!');
}


    public function show(Collection $collection)
    {
        return view('admin.collection.show', compact('collection'));
    }

    public function edit(Collection $collection)
    {
        return view('admin.collection.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        $path = $collection->banner_image;
        if ($request->hasFile('banner_image')) {
            // পুরানো image delete করো
            if ($collection->banner_image && Storage::disk('public')->exists($collection->banner_image)) {
                Storage::disk('public')->delete($collection->banner_image);
            }
            $path = $request->file('banner_image')->store('collections', 'public');
        }

        $collection->update([
            'title' => $request->title,
            'description' => $request->description,
            'brand' => $request->brand,
            'short_description' => $request->short_description,
            'banner_image'=> $path,
            'is_featured' => $request->boolean('is_featured', false),
        ]);

        return redirect()->route('collections.index')->with('success', 'Collection updated successfully!');
    }

    public function destroy(Collection $collection)
    {
        if ($collection->banner_image && Storage::disk('public')->exists($collection->banner_image)) {
            Storage::disk('public')->delete($collection->banner_image);
        }

        $collection->delete();

        return redirect()->back()->with('success', 'Collection deleted successfully!');
    }
}
