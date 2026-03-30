<?php

namespace App\Http\Controllers\Api\Admin\Banner;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    //     public function index()
    // {
    //     return Banner::with('sub-category')->get();
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //          'title' => 'required|string|max:255',
    //          'description' => 'nullable|string',
    //         'banner_desktop_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    //         'banner_mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

    //     ]);

    //     $banner = Banner::create($validated);

    //     if (!empty($validated['products'])) {
    //         $banner->products()->sync($validated['products']);
    //     }

    //     return response()->json($banner->load('products'), 201);
    // }


    public function index()                         //this for "link": "sub-category/kurta-sets",
{
    $banners = Banner::with('subCategory')->get(); // eager load relation

    $formatted = $banners->map(function ($banner) {
        return [
            'id' => $banner->id,
            'title' => $banner->title,
            'link' => 'sub-category/' . ($banner->subCategory->slug ?? ''),
            'images' => [
                'desktop' => $banner->banner_desktop_image
                    ? asset('storage/' . $banner->banner_desktop_image)
                    : null,
                'mobile' => $banner->banner_mobile_image
                    ? asset('storage/' . $banner->banner_mobile_image)
                    : null,
            ],
            'slug' => $banner->slug,
        ];
    });

    return response()->json(
        [
            'success' => true,
            'data' => $formatted
        ]
    );
}


    // public function index()                      //this for "link": "http://192.168.0.108:8000/sub-category/kurta-sets",
    // {
    //     $banners = Banner::with('subCategory')->get(); // eager load relation
    //     return Banner::with('subCategory')->get();
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'banner_desktop_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // create slug
        $validated['slug'] = \Str::slug($validated['title']);

        // Desktop image
        if ($request->hasFile('banner_desktop_image')) {
            $validated['banner_desktop_image'] = $request->file('banner_desktop_image')->store('banners/desktop', 'public');
        }

        // Mobile image
        if ($request->hasFile('banner_mobile_image')) {
            $validated['banner_mobile_image'] = $request->file('banner_mobile_image')->store('banners/mobile', 'public');
        }

        $banner = Banner::create($validated);

        return response()->json($banner, 201);
    }
}
