<?php

namespace App\Http\Controllers\View\PopularCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PopularCategory;
use App\Models\Department;
use App\Models\Category;
use App\Models\SubCategory;



class PopularCategoryController extends Controller
{
    // PopularCategoryController.php
public function index(Request $request)
{
    // =================== Dropdown Data ===================
    $departments   = Department::all();
    $categories    = Category::all();
    $subCategories = SubCategory::all();

    // =================== Search + Pagination ===================
    $search  = $request->input('search');
    $perPage = (int) $request->input('perPage', $request->input('per_page', 10));
    if (! in_array($perPage, [10, 25, 50], true)) {
        $perPage = 10;
    }

    $query = PopularCategory::with(['department','category','subCategory']);

    if($search) {
        $query->where('title', 'like', "%{$search}%");
    }

    $popularCategories = $query->orderBy('title')
                               ->paginate($perPage)
                               ->withQueryString();

    return view('admin.popularCategories.index', compact(
        'popularCategories', 'departments', 'categories', 'subCategories'
    ));
}


    public function create()
    {
        $departments = Department::all();
        $categories = Category::all();
        $subCategories = SubCategory::all();
        return view('admin.popularCategories.create', compact('departments','categories','subCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'desktop_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('desktop_image')) {
            $validated['desktop_image'] = $request->file('desktop_image')->store('popular_categories/desktop','public');
        }

        if ($request->hasFile('mobile_image')) {
            $validated['mobile_image'] = $request->file('mobile_image')->store('popular_categories/mobile','public');
        }

        PopularCategory::create($validated);
        return redirect()->route('popular_categories.index')->with('success','Popular Category Created Successfully');
    }

    public function edit(PopularCategory $popularCategory)
    {
        $departments = Department::all();
        $categories = Category::all();
        $subCategories = SubCategory::all();
        return view('admin.popularCategories.edit', compact('popularCategory','departments','categories','subCategories'));
    }

    public function update(Request $request, PopularCategory $popularCategory)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'desktop_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('desktop_image')) {
            $validated['desktop_image'] = $request->file('desktop_image')->store('popular_categories/desktop','public');
        }

        if ($request->hasFile('mobile_image')) {
            $validated['mobile_image'] = $request->file('mobile_image')->store('popular_categories/mobile','public');
        }

        $popularCategory->update($validated);
        return redirect()->route('popular_categories.index')->with('success','Popular Category Updated Successfully');
    }

    public function destroy(PopularCategory $popularCategory)
    {
        $popularCategory->delete();
        return redirect()->back()->with('success','Popular Category Deleted Successfully');
    }

    public function show(PopularCategory $popularCategory)
    {
        return view('admin.popularCategories.show', compact('popularCategory'));
    }
}
