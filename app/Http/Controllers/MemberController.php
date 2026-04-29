<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function indexTabs(Request $request)
    {
        return view('pages/community/users-tabs');
    }

    public function indexTiles(Request $request)
    {
        return view('pages/community/users-tiles');
    }
}
