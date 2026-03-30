<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'in:admin,supervisor,user',
        ]);

        // if ($validator->fails()) {
        //     $errors = $validator->errors()->all(); // Flattened array of errors

        //     return response()->json([
        //         'success' => false,
        //         'status' => 422,
        //         'message' => 'Validation failed',
        //         'errors' => $errors,
        //     ], 422); // Matches ApiErrorResponse
        // }
// ........................................................................
//          if ($validator->fails()) {
//     // all error message show one array
//     $flattenedErrors = collect($validator->errors()->all());

//     return response()->json([
//         'message' => 'Validation failed',
//         'errors' => $flattenedErrors,
//     ], 422);
// }

// ................................................................

if ($validator->fails()) {
    return response()->json([
        'success' => false,
        'status' => 422,
        'message' => 'Validation failed',
        'errors' => $validator->errors()->all(), // Flat array of messages
    ], 422);
}



        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'user',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'status' => 201,
            'message' => 'Registration Successful',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                ],
            ],
        ], 201); // Matches ApiSuccessResponse / LoginResponse
    }



public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'status' => 422,
            'message' => 'Validation failed',
            'errors' => $validator->errors()->all(),
        ], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'status' => 401,
            'message' => 'Invalid credentials',
            'errors' => ['The email or password you entered is incorrect.'],
        ], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'success' => true,
        'status' => 200,
        'message' => 'Login successful',
        'data' => [
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
            ],
        ],
    ], 200);
}



    // public function login(Request $request)
    // {
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response()->json([
    //             'success' => false,
    //             'status' => 401,
    //             'message' => 'Invalid credentials',
    //             'errors' => ['The email or password you entered is incorrect.'],
    //         ], 401); // Matches LoginFailure
    //     }

    //     $token = $user->createToken('api-token')->plainTextToken;

    //     return response()->json([
    //         'success' => true,
    //         'status' => 200,
    //         'message' => 'Login successful',
    //         'data' => [
    //             'token' => $token,
    //             'user' => [
    //                 'id' => $user->id,
    //                 'email' => $user->email,
    //                 'name' => $user->name,
    //             ],
    //         ],
    //     ], 200); // Matches LoginResponse
    // }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Logged out',
        ]);
    }


}
