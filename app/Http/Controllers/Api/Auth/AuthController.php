<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\GuestCookie;
use App\Support\GuestShoppingMerger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

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
                    'phone' => $user->phone,
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

    GuestShoppingMerger::mergeIntoUserFromToken($request->cookie(GuestCookie::NAME), $user);

    $response = response()->json([
        'success' => true,
        'status' => 200,
        'message' => 'Login successful',
        'data' => [
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'phone' => $user->phone,
            ],
        ],
    ], 200);

    $response->cookie(GuestCookie::forget());

    return $response;
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

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        try {
            $status = Password::sendResetLink($validator->validated());
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Unable to send password reset email. Please check mail configuration.',
                'errors' => [$exception->getMessage()],
            ], 500);
        }

        if ($status !== Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => __($status),
                'errors' => [__($status)],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Password reset link sent successfully.',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $status = Password::reset(
            $validator->validated(),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => __($status),
                'errors' => [__($status)],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Password reset successfully.',
        ]);
    }

    public function changePassword(Request $request)
    {
        if (! $request->user()) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthenticated. Please login first.',
                'errors' => ['Unauthenticated. Please login first.'],
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $user = $request->user();

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'The current password is incorrect.',
                'errors' => ['The current password is incorrect.'],
            ], 422);
        }

        $user->forceFill([
            'password' => Hash::make($request->input('password')),
            'remember_token' => Str::random(60),
        ])->save();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Password changed successfully.',
        ]);
    }

    public function userDetails(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthenticated. Please login first.',
                'errors' => ['Unauthenticated. Please login first.'],
            ], 401);
        }

        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role ?? null,
            ],
        ]);
    }

    public function updateUserDetails(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthenticated. Please login first.',
                'errors' => ['Unauthenticated. Please login first.'],
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $user->update($validator->validated());

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Profile updated successfully.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role ?? null,
            ],
        ]);
    }


}
