<?php

namespace App\Http\Controllers\View\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;



class DepartmentController extends Controller
{
     public function create()
{

    return view('admin.department.create');
}

// Show all categories
//  public function index()
//     {
//         $departments = Department::all(); // or paginate, etc.

//         return view('admin.department.index', compact('departments'));
//     }


public function index(Request $request)
{
    $search = $request->input('search');
    $perPage = $request->input('perPage', 10); // default 10 per page

    $query = Department::query();

    if ($search) {
        $query->where('name', 'like', "%{$search}%");
    }

    // ================= EXPORT LOGIC =================
    if ($request->has('export_ids')) {
        $exportIds = $request->get('export_ids'); // array of selected IDs
        $exportData = Department::whereIn('id', $exportIds)->orderBy('name')->get();

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

    $departments = $query->orderBy('name')->paginate($perPage)->withQueryString();

    return view('admin.department.index', compact('departments'));
}

// public function index(Request $request)
// {
//     $search = $request->input('search');
//     $perPage = $request->input('perPage', 10); // default 10 per page

//     $query = Department::query();

//     if ($search) {
//         $query->where('name', 'like', "%{$search}%");
//     }

//     $departments = $query->orderBy('name')->paginate($perPage);

//     return view('admin.department.index', compact('departments'));
// }



 public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Department::create([
            'name' => $request->name,
             'slug' => Str::slug($request->name)
        ]);



        toastr()->success('Department added successfully!');
        return redirect()->route('departments.index');
        // ->with('success', 'Department added successfully!');
    }



    // Show single category
    public function show(Department $department)
    {
        return view('admin.department.show', compact('subCategory'));
    }

    // Show edit form
    public function edit(Department $department)
    {

        return view('admin.department.edit', compact('department'));

    }

    // Update department
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $department->update([
            'name' => $request->name
        ]);

        toastr()->success('Department updated successfully!');
        return redirect()->route('departments.index', $department);
        // ->with('success', 'Department updated successfully!');
    }

    // Delete department
    public function destroy(Department $department)
    {
        $department->delete();

        toastr()->success('Department deleted successfully!');
        return redirect()->back();
        // ->with('success', 'Department deleted successfully!');
    }
}
