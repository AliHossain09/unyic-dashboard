<?php

namespace App\Http\Controllers\View\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Department;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CategoryController extends Controller
{

// Show all categories
//  public function index()
//     {
//         $categories = Category::all(); // or paginate, etc.

//         return view('admin.category.index', compact('categories'));
//     }

    public function index(Request $request)
{
     $departments = Department::all();
    $search = $request->input('search');
    $perPage = $request->input('perPage', 10); // default 10 per page

    $query = Category::query();

    if ($search) {
        $query->where('name', 'like', "%{$search}%");
    }

    // ================= EXPORT LOGIC =================
    if ($request->has('export_ids')) {
        $exportIds = $request->get('export_ids'); // array of selected IDs
        $exportData = Category::whereIn('id', $exportIds)->orderBy('name')->get();

        $filename = 'categories_export_'.date('Ymd_His').'.csv';

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

    $categories = $query->orderBy('name')->paginate($perPage)->withQueryString();

     return view('admin.category.index', compact('categories', 'departments'));
}



    // Show create form
    public function create()
    {
        $departments = Department::all();
        return view('admin.category.create', compact('departments'));
    }

    // Store category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id'
        ]);

        Category::create([
            'name' => $request->name,
            'department_id' => $request->department_id
        ]);

        return redirect()->route('categories.create')->with('success', 'Category added successfully!');
    }


    // Show single category
    public function show(Category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    // Show edit form
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('categories.index', $category)->with('success', 'Category updated successfully!');
    }

    // Delete category
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}
