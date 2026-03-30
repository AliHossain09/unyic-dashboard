<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\User;
// use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Hash;

// class AuthController extends Controller
// {
    // public function register(Request $req)
    // {
    //     $req->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|confirmed',
    //     ]);

    //     $user = User::create([
    //         'name' => $req->name,
    //         'email' => $req->email,
    //         'password' => Hash::make($req->password),
    //     ]);

    //     $token = $user->createToken('api-token')->plainTextToken;

    //     return response()->json(['user' => $user, 'token' => $token], 201);
    // }



// public function register(Request $req)
// {
//     $validator = Validator::make($req->all(), [
//         'name' => 'required',
//         'email' => 'required|email|unique:users',
//         'password' => 'required',
//         'role' => 'in:admin,supervisor,user',
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'message' => 'Validation failed',
//             'errors' => $validator->errors(),
//         ], 422);
//     }

//     $validated = $validator->validated();

//     $user = User::create([
//         'name' => $validated['name'],
//         'email' => $validated['email'],
//         'password' => Hash::make($validated['password']),
//         'role' => $validated['role'] ?? 'user',
//     ]);

//     $token = $user->createToken('api-token')->plainTextToken;

//     return response()->json([
//         'message' => 'Registration Successful',
//         'user' => $user,
//         'token' => $token,
//     ], 201);
// }




//     public function login(Request $request)
//     {
//         $user = User::where('email', $request->email)->first();

//         if (!$user || !Hash::check($request->password, $user->password)) {
//             return response()->json(['error' => 'Invalid credentials'], 401);
//         }

//         $token = $user->createToken('api-token')->plainTextToken;

//         // return response()->json([
//         //     'user' => $user,
//         //     'token' => $token
//         // ]);

//         return response()->json([
//         'user' => $user,
//         'token' => $token,
//         'role' => $user->role // include role
// ]);

//     }

//     public function logout(Request $request)
//     {
//         $request->user()->currentAccessToken()->delete();

//         return response()->json(['message' => 'Logged out']);
//     }
// }
