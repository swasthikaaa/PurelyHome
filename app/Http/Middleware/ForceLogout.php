<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceLogout
{
    public function handle($request, Closure $next)
    {
        // A unique key that changes every time the PHP process restarts
        $currentKey = config('app.boot_uuid');               // set in AppServiceProvider@boot
        $sessionKey = $request->session()->get('boot_uuid'); // stored in user's session

        if ($sessionKey !== $currentKey) {
            // If user was logged in from a prior run, log them out
            if (Auth::check()) {
                Auth::logout();
            }

            // Kill old session and start a fresh one
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->session()->regenerate();

            // Store the new boot key so subsequent requests won't loop
            $request->session()->put('boot_uuid', $currentKey);

            // Allow auth pages to proceed; otherwise send to login
            $isAuthRoute =
                $request->routeIs('login') ||
                $request->routeIs('register') ||
                $request->routeIs('password.*') ||
                $request->routeIs('otp.verify') ||
                $request->routeIs('otp.verify.post');

            if ($isAuthRoute) {
                return $next($request);
            }

            return redirect()->route('login')
                ->with('status', 'Session expired. Please log in again.');
        }

        return $next($request);
    }
}
