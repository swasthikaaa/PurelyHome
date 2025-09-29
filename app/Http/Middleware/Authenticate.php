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
        // If API request → return 401 JSON instead of redirect
        if ($request->is('api/*') || $request->expectsJson()) {
            abort(response()->json([
                'error' => 'Unauthenticated',
                'message' => 'Please provide a valid Sanctum token.'
            ], 401));
        }

        // For web routes → always redirect to login
        return route('login');
    }
}
