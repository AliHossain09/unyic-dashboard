<?php

namespace App\Exceptions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;




class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     *  When user is not authenticated (API case)
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {


        if ($request->is('api/*')) {
        return response()->json([
            'success' => false,
            'status' => 401,
            'message' => 'Unauthenticated. Please login first.'
        ], 401);
    }

    if ($request->expectsJson()) {
        return response()->json([
            'success' => false,
            'status' => 401,
            'message' => 'Unauthenticated. Please login first.'
        ], 401);
    }

    return redirect()->guest(route('login'));
    }


    public function render($request, Throwable $exception)
{
    // Handle Model Not Found for API
    if ($exception instanceof ModelNotFoundException) {
        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found.'
            ], 404);
        }
    }

    // fallback to parent
    return parent::render($request, $exception);
}





}
