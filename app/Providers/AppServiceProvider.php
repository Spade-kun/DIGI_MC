<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share pending users count with admin views
        view()->composer('layouts.dashboard', function ($view) {
            $pendingCount = \App\Models\User::where('status', 'pending')->count();
            $view->with('pendingCount', $pendingCount);
        });
        
        view()->composer('admin.users.index', function ($view) {
            // The counts are already passed from the controller
            // This ensures the view always has access to them
        });
    }
}
