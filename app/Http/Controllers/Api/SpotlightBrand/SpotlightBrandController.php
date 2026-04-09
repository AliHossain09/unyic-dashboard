<?php

namespace App\Http\Controllers\Api\SpotlightBrand;

use App\Http\Controllers\Controller;
use App\Models\SpotlightBrand;

class SpotlightBrandController extends Controller
{
    public function index()
    {
        try {
            $brands = SpotlightBrand::query()
                ->where('is_active', true)
                ->orderBy('serial')
                ->orderByDesc('id')
                ->limit(2)
                ->get()
                ->map(function (SpotlightBrand $item) {
                    return [
                        'id' => $item->id,
                        'slug' => $item->slug,
                        'name' => $item->brand,
                        'image' => asset('storage/' . $item->image),
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'message' => 'Spotlight brands fetched successfully',
                'data' => $brands,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch spotlight brands',
            ], 500);
        }
    }
}
