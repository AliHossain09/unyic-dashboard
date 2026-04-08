<?php

namespace App\Http\Controllers\Api\Frontend\Collection;

use App\Http\Controllers\Controller;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function featured()
    {
        try {
            $collections = Collection::query()
                ->where('is_featured', true)
                ->latest()
                ->get()
                ->map(function ($collection) {
                    return [
                        'id' => $collection->id,
                        'slug' => $collection->slug,
                        'name' => $collection->title,
                        'image' => $collection->banner_image ? asset('storage/' . $collection->banner_image) : null,
                        'brand' => $collection->brand,
                        'short_description' => $collection->short_description,
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'message' => 'Featured collections fetched successfully',
                'data' => $collections,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch featured collections',
            ], 500);
        }
    }
}
