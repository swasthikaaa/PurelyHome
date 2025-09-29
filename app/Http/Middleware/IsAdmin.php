<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // 🚨 If user not logged in → redirect to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 🚨 If logged in but not admin → block
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        // ✅ Allow admin through
        return $next($request);
    }
}
