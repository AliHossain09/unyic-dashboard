<?php

namespace App\Http\Controllers\Api\NewArrivalCategory;

use App\Http\Controllers\Controller;
use App\Models\NewArrivalCategory;

class NewArrivalCategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = NewArrivalCategory::with('category')
                ->latest()
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->category->id,
                        'slug' => $item->category->slug,
                        'name' => $item->category->name,
                        'image' => asset('storage/' . $item->image),
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'message' => 'Categories fetched successfully',
                'data' => $categories,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories',
            ], 500);
        }
    }
}
