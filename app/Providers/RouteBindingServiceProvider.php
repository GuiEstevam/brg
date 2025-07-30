<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteBindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Route::model('role', Role::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
