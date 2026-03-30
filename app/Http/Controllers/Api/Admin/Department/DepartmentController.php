<?php

namespace App\Http\Controllers\Api\Admin\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
     // Show all Departments
 public function index()
{
    $departments = Department::all(); // without paginate()
    // $departments = Department::paginate(10);

    return response()->json([
        'success' => true,
        'data' => $departments,
        'message' => 'Department list fetched successfully'
    ], 200);
}

    // ✅ Store (POST /api/Departments)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $department = Department::create($validated);

        return response()->json([
            'message' => 'Department created successfully!',
            'data' => $department
        ], 201);
    }

    // ✅ Edit / Show single (GET /api/Departments/{id})
    public function show($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        return response()->json([
            'data' => $department
        ]);
    }

    // ✅ Update (PUT /api/Departments/{id})
    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $department->update($validated);

        return response()->json([
            'message' => 'Department updated successfully!',
            'data' => $department
        ]);
    }

    // ✅ Delete (DELETE /api/Departments/{id})
    public function destroy($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully!'
        ]);
    }
}
