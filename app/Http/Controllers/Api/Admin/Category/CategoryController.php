<?php

namespace App\Http\Controllers\Api\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
     // Show all categories
 public function index()
{
    $categories = Category::all(); // without paginate()
    // $categories = Category::paginate(10);

    return response()->json([
        'success' => true,
        'data' => $categories,
        'message' => 'Category list fetched successfully'
    ], 200);
}

    // ✅ Store (POST /api/categories)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully!',
            'data' => $category
        ], 201);
    }

    // ✅ Edit / Show single (GET /api/categories/{id})
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json([
            'data' => $category
        ]);
    }

    // ✅ Update (PUT /api/categories/{id})
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully!',
            'data' => $category
        ]);
    }

    // ✅ Delete (DELETE /api/categories/{id})
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully!'
        ]);
    }
}
