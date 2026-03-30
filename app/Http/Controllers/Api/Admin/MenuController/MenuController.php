<?php

namespace App\Http\Controllers\Api\Admin\MenuController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class MenuController extends Controller
{
     public function index()
    {
        // Load departments -> categories -> subCategories
        $departments = Department::with('categories.subCategories')->get();

        return response()->json(
             [
            'success' => true,
            'data' => $departments
        ] );
    }
}
