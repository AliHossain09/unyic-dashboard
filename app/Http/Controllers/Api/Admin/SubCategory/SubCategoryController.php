<?php

namespace App\Http\Controllers\Api\Admin\SubCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoryController extends Controller
{
       // Show all categories
public function index()
{
    $subCategories = SubCategory::all();

    return response()->json([
        'success' => true,
        'data' => $subCategories, // ✅ ঠিক ভেরিয়েবল
        'message' => 'Sub Category list fetched successfully'
    ], 200);
}

    // ✅ Store (POST /api/categories)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subCategory = SubCategory::create($validated);

        return response()->json([
            'message' => 'Sub Category created successfully!',
            'data' => $subCategory
        ], 201);
    }

    // ✅ Edit / Show single (GET /api/categories/{id})
    public function show($id)
    {
        $subCategory = SubCategory::find($id);

        if (!$subCategory) {
            return response()->json(['message' => 'Sub Category not found'], 404);
        }

        return response()->json([
            'data' => $subCategory
        ]);
    }

    // ✅ Update (PUT /api/categories/{id})
    public function update(Request $request, $id)
    {
        $subCategory = SubCategory::find($id);

        if (!$subCategory) {
            return response()->json(['message' => 'Sub Category not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subCategory->update($validated);

        return response()->json([
            'message' => 'Sub Category updated successfully!',
            'data' => $subCategory
        ]);
    }

    // ✅ Delete (DELETE /api/categories/{id})
    public function destroy($id)
    {
        $subCategory = SubCategory::find($id);

        if (!$subCategory) {
            return response()->json(['message' => 'Sub Category not found'], 404);
        }

        $subCategory->delete();

        return response()->json([
            'message' => 'Sub Category deleted successfully!'
        ]);
    }
}
