<?php

namespace App\Http\Controllers\View\SubCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubCategoryController extends Controller
{

public function index(Request $request)
{
    $categories = Category::all();
    $search = $request->input('search');
    $perPage = (int) $request->input('perPage', $request->input('per_page', 10)); // backward compatible
    if (! in_array($perPage, [10, 25, 50], true)) {
        $perPage = 10;
    }

    $query = SubCategory::query();

    if ($search) {
        $query->where('name', 'like', "%{$search}%");
    }

    // ================= EXPORT LOGIC =================
    if ($request->has('export_ids')) {
        $exportIds = $request->get('export_ids'); // array of selected IDs
        $exportData = SubCategory::whereIn('id', $exportIds)->orderBy('name')->get();

        $filename = 'subCategories_export_'.date('Ymd_His').'.csv';

        $response = new StreamedResponse(function() use ($exportData) {
            $handle = fopen('php://output', 'w');

            // CSV header
            fputcsv($handle, ['ID', 'Name', 'Created At']);

            // Data rows
            foreach ($exportData as $dept) {
                fputcsv($handle, [
                    $dept->id,
                    $dept->name,
                    $dept->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
    // =================================================

    $subCategories = $query->orderBy('name')->paginate($perPage)->withQueryString();

    return view('admin.subCategory.index', compact('subCategories', 'categories'));
}



// Show all categories
//  public function index()
//     {
//         $subCategories = SubCategory::all(); // or paginate, etc.

//         return view('admin.subCategory.index', compact('subCategories'));
//     }
// ..........................................................................................
    // Show create form
    // public function create()
    // {
    //     return view('admin.subCategory.create');
    // }

    public function create()
{
    $categories = Category::all(); // fetch all categories

    return view('admin.subCategory.create', compact('categories'));
}

    // Store category
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255'
    //     ]);

    //     SubCategory::create([
    //         'name' => $request->name
    //     ]);

    //     return redirect()->route('subCategories.create')->with('success', 'Sub Category added successfully!');
    // }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id'
    ]);

    SubCategory::create([
        'name' => $request->name,
        'category_id' => $request->category_id
    ]);

    return redirect()->route('subCategories.create')->with('success', 'Sub Category added successfully!');
}


    // Show single category
    public function show(SubCategory $subCategory)
    {
        return view('admin.subCategory.show', compact('subCategory'));
    }

    // Show edit form
    public function edit(SubCategory $subCategory)
    {

        return view('admin.subCategory.edit', compact('subCategory'));

    }

    // Update category
    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $subCategory->update([
            'name' => $request->name
        ]);

        return redirect()->route('subCategories.index', $subCategory)->with('success', 'Sub Category updated successfully!');
    }

    // Delete category
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();

        return redirect()->back()->with('success', 'Sub Category deleted successfully!');
    }
}
