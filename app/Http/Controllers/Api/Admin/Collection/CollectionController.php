<?php

namespace App\Http\Controllers\Api\Admin\Collection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function index()
    {
        return Collection::with('products')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'products' => 'array'
        ]);

        $collection = Collection::create($validated);

        if (!empty($validated['products'])) {
            $collection->products()->sync($validated['products']);
        }

        return response()->json($collection->load('products'), 201);
    }
}
