<?php

namespace App\Http\Controllers\Api\Admin\PopularCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PopularCategory;
use Illuminate\Support\Facades\Storage;

class PopularCategoryController extends Controller
{
     public function index()
    {
        $popularCategories = PopularCategory::with(['department', 'category', 'subCategory'])->get();

        $data = $popularCategories->map(function ($item) {
            // 🔗 Dynamic link (priority: subCategory > category > department)
            if ($item->subCategory) {
                $link = 'sub-category/' . $item->subCategory->slug;
            } elseif ($item->category) {
                $link = 'category/' . $item->category->slug;
            } elseif ($item->department) {
                $link = 'department/' . $item->department->slug;
            } else {
                $link = null;
            }

            return [
                'id' => $item->id,
                'title' => $item->title,
                'link' => $link,
                'images' => [
                    'desktop' => $item->desktop_image ? asset('storage/' . $item->desktop_image) : null,
                    'mobile'  => $item->mobile_image ? asset('storage/' . $item->mobile_image) : null,
                ],
                'slug' => $item->slug,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'desktop_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
        ]);

        $data = $request->only(['title', 'department_id', 'category_id', 'sub_category_id']);

        if ($request->hasFile('desktop_image')) {
            $data['desktop_image'] = $request->file('desktop_image')->store('popular_categories', 'public');
        }
        if ($request->hasFile('mobile_image')) {
            $data['mobile_image'] = $request->file('mobile_image')->store('popular_categories', 'public');
        }

        $popularCategory = PopularCategory::create($data);
        return response()->json(['success' => true, 'data' => $popularCategory], 201);
    }

    public function update(Request $request, $id)
    {
        $popularCategory = PopularCategory::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'desktop_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
        ]);

        $data = $request->only(['title', 'department_id', 'category_id', 'sub_category_id']);

        if ($request->hasFile('desktop_image')) {
            if ($popularCategory->desktop_image) Storage::disk('public')->delete($popularCategory->desktop_image);
            $data['desktop_image'] = $request->file('desktop_image')->store('popular_categories', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            if ($popularCategory->mobile_image) Storage::disk('public')->delete($popularCategory->mobile_image);
            $data['mobile_image'] = $request->file('mobile_image')->store('popular_categories', 'public');
        }

        $popularCategory->update($data);
        return response()->json(['success' => true, 'data' => $popularCategory]);
    }

    public function destroy($id)
    {
        $popularCategory = PopularCategory::findOrFail($id);

        if ($popularCategory->desktop_image) Storage::disk('public')->delete($popularCategory->desktop_image);
        if ($popularCategory->mobile_image) Storage::disk('public')->delete($popularCategory->mobile_image);

        $popularCategory->delete();
        return response()->json(['success' => true, 'message' => 'Popular Category deleted successfully.']);
    }
}
