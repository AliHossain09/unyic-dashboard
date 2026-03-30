<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class YourController extends Controller
{
    public function checkEmail(Request $request)
{
    $email = strtolower($request->input('email'));

   // \Log::info('Checking email: ' . $email); // debug log

    $exists = User::whereRaw('LOWER(email) = ?', [$email])->exists();

    return response()->json([
        'exists' => $exists,
        'message' => $exists ? 'Email is already taken' : 'Email is available'
    ]);
}
}
