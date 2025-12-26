<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\Products;
use App\Livewire\Collections;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production' || env('VERCEL')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Generate a unique value on every PHP process boot (restarts when you re-run `php artisan serve`)
        config()->set('app.boot_uuid', (string) Str::uuid());

        // Your existing Livewire registrations
        Livewire::component('products', Products::class);
        Livewire::component('collections', Collections::class);
    }
}
