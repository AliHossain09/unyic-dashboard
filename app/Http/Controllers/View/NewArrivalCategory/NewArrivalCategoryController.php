<?php

namespace App\Http\Controllers\View\NewArrivalCategory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\NewArrivalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewArrivalCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = (int) $request->input('perPage', 10);

        if (! in_array($perPage, [10, 25, 50], true)) {
            $perPage = 10;
        }

        $query = NewArrivalCategory::with('category');

        if ($search) {
            $query->whereHas('category', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $newArrivalCategories = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.newArrivalCategories.index', compact(
            'newArrivalCategories',
            'categories'
        ));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.newArrivalCategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id|unique:new_arrival_categories,category_id',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['image'] = $request->file('image')->store('new_arrival_categories', 'public');

        NewArrivalCategory::create($validated);

        return redirect()
            ->route('new_arrival_categories.index')
            ->with('success', 'New arrival category created successfully.');
    }

    public function show(NewArrivalCategory $newArrivalCategory)
    {
        $newArrivalCategory->load('category');

        return view('admin.newArrivalCategories.show', compact('newArrivalCategory'));
    }

    public function edit(NewArrivalCategory $newArrivalCategory)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.newArrivalCategories.edit', compact('newArrivalCategory', 'categories'));
    }

    public function update(Request $request, NewArrivalCategory $newArrivalCategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id|unique:new_arrival_categories,category_id,' . $newArrivalCategory->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($newArrivalCategory->image && Storage::disk('public')->exists($newArrivalCategory->image)) {
                Storage::disk('public')->delete($newArrivalCategory->image);
            }

            $validated['image'] = $request->file('image')->store('new_arrival_categories', 'public');
        }

        $newArrivalCategory->update($validated);

        return redirect()
            ->route('new_arrival_categories.index')
            ->with('success', 'New arrival category updated successfully.');
    }

    public function destroy(NewArrivalCategory $newArrivalCategory)
    {
        if ($newArrivalCategory->image && Storage::disk('public')->exists($newArrivalCategory->image)) {
            Storage::disk('public')->delete($newArrivalCategory->image);
        }

        $newArrivalCategory->delete();

        return redirect()
            ->route('new_arrival_categories.index')
            ->with('success', 'New arrival category deleted successfully.');
    }
}
