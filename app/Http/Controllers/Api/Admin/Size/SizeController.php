<?php

namespace App\Http\Controllers\Api\Admin\Size;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SizeController extends Controller
{
     // Show all sizes
 public function index()
{
    $sizes = Size::all(); // without paginate()
    // $sizes = Size::paginate(10);

    return response()->json([
        'success' => true,
        'data' => $sizes,
        'message' => 'Size list fetched successfully'
    ], 200);
}

    // ✅ Store (POST /api/size)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $size = Size::create($validated);

        return response()->json([
            'message' => 'Size created successfully!',
            'data' => $size
        ], 201);
    }

    // ✅ Edit / Show single (GET /api/size/{id})
    public function show($id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json(['message' => 'Size not found'], 404);
        }

        return response()->json([
            'data' => $size
        ]);
    }

    // ✅ Update (PUT /api/sizes/{id})
    public function update(Request $request, $id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json(['message' => 'Size not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $size->update($validated);

        return response()->json([
            'message' => 'Size updated successfully!',
            'data' => $size
        ]);
    }

    // ✅ Delete (DELETE /api/Size/{id})
    public function destroy($id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json(['message' => 'Size not found'], 404);
        }

        $size->delete();

        return response()->json([
            'message' => 'Size deleted successfully!'
        ]);
    }
}
