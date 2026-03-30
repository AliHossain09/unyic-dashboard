<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
      /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // API এর ক্ষেত্রে redirect হবে না, শুধু JSON response দিবে
        if (! $request->expectsJson()) {
            return null;
        }
    }

    /**
     * Override unauthenticated to always return JSON for API.
     */
    protected function unauthenticated($request, array $guards)
    {
        return response()->json([
            'success' => false,
            'status'  => 401,
            'message' => 'Unauthenticated.'
        ], 401);
    }
}
