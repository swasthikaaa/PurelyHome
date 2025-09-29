<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for customers.
     */
    public const HOME = '/dashboard';

    /**
     * The path to the "home" route for admins.
     */
    public const ADMIN_HOME = '/admin/dashboard';

    /**
     * The path to redirect users after logout.
     */
    public const LOGOUT = '/login';

    /**
     * Define your route model bindings, pattern filters, and other route configurations.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
