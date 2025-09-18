<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
        Inertia::share([
        'auth' => fn () => [
            'user' => Auth::user(),
        ],
        'unreadCount' => fn () => Auth::check()
            ? Auth::user()->customNotifications()->where('lida', false)->count()
            : 0,
    ]);

    }
}
