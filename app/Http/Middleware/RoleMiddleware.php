<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles):Response
    {
        if (!in_array($request->user()->role, $roles)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);

    //     $user = $request->user();

    //     //  dd($user);

    // // যদি ইউজার না থাকে (মানে null), তাহলে Unauthorized দেখাও
    // if (!$user || !in_array($user->role, $roles)) {
    //     return response()->json(['error' => 'Unauthorized'], 403);
    // }

    // return $next($request);
    // }
}
}
