<?php

namespace App\Http\Controllers\View\Size;

use App\Models\Size;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SizeController extends Controller
{
    public function create()
{

    return view('admin.size.create');
}

// Show all categories
//  public function index()
//     {
//         $sizes = Size::all(); // or paginate, etc.

//         return view('admin.size.index', compact('sizes'));
//     }


public function index(Request $request)
{
    $search = $request->input('search');
    $perPage = $request->input('perPage', 10); // default 10 per page

    $query = Size::query();

    if ($search) {
        $query->where('name', 'like', "%{$search}%");
    }

    // ================= EXPORT LOGIC =================
    if ($request->has('export_ids')) {
        $exportIds = $request->get('export_ids'); // array of selected IDs
        $exportData = Size::whereIn('id', $exportIds)->orderBy('name')->get();

        $filename = 'departments_export_'.date('Ymd_His').'.csv';

        $response = new StreamedResponse(function() use ($exportData) {
            $handle = fopen('php://output', 'w');

            // CSV header
            fputcsv($handle, ['ID', 'Name', 'Created At']);

            // Data rows
            foreach ($exportData as $dept) {
                fputcsv($handle, [
                    $dept->id,
                    $dept->name,
                    $dept->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
    // =================================================

    $sizes = $query->orderBy('name')->paginate($perPage)->withQueryString();

    return view('admin.size.index', compact('sizes'));
}

 public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Size::create([
            'name' => $request->name,
             'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('sizes.create')->with('success', 'Size added successfully!');
    }



    // Show single size
    public function show(Size $size)
    {
        return view('admin.size.show', compact('size'));
    }

    // Show edit form
    public function edit(Size $size)
    {

        return view('admin.size.edit', compact('size'));

    }

    // Update size
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $size->update([
            'name' => $request->name
        ]);

        return redirect()->route('sizes.index', $size)->with('success', 'Size updated successfully!');
    }

    // Delete size
    public function destroy(Size $size)
    {
        $size->delete();

        return redirect()->back()->with('success', 'Size deleted successfully!');
    }
}
