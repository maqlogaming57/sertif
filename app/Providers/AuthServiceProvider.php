<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        // Gate untuk admin
        Gate::define('isAdmin', function ($user) {
            return $user->role === '1'; // Sesuaikan nama kolom role Anda
        });
    }
}
