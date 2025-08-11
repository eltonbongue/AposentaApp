<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

   Route::get('/calculateamount', function () {
        return Inertia::render('CalculateAmount');
    })->name('calculateamount');

    Route::get('/simulatecenario', function () {
        return Inertia::render('SimulateScenario');
    })->name('simulatecenario');

       Route::get('/financechat', function () {
        return Inertia::render('FinanceChat');
    })->name('financechat');

    
});
