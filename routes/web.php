<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Profile\FinancialProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IAChatController;

/*
|--------------------------------------------------------------------------
| ROTA PÚBLICA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});


Route::get('/know-more', function () {
    return Inertia::render('KnowMore');
})->name('know-more');


 // Chat IA (SPA)
    Route::post('/chat/ia', [IAChatController::class, 'responder'])->name('chat.ia');


/*
|--------------------------------------------------------------------------
| ROTAS ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    // Autenticação admin
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Rotas protegidas para admins
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Gestão de usuários
        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        // Notificações admin
        // Em routes/web.php
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
    ->name('admin.notifications.destroy');

        Route::get('/notificacoes', [NotificationController::class, 'adminIndex'])->name('admin.notificacoes');
        Route::post('/notifications', [NotificationController::class, 'store'])->name('admin.notifications.store');
    });
});

/*
|--------------------------------------------------------------------------
| ROTAS USUÁRIO AUTENTICADO (SPA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    // Outras páginas
    Route::get('/calculateamount', fn() => Inertia::render('CalculateAmount'))->name('calculateamount');
    Route::get('/financechat', fn() => Inertia::render('FinanceChat'))->name('financechat');

    // Página de notificações
    Route::get('/notificacoes', [NotificationController::class, 'index'])->name('notificacoes');
    Route::delete('/notificacoes/{notification}', [NotificationController::class, 'destroy']); // <- Nova rota
    // Perfil financeiro
    Route::prefix('profile')->group(function () {
        Route::get('/financial-profile', [FinancialProfileController::class, 'show'])
            ->name('profile.financial-profile.show');
        Route::put('/financial-profile', [FinancialProfileController::class, 'update'])
            ->name('profile.financial-profile.update');
        Route::get('/financial-profile/metas', [FinancialProfileController::class, 'getMetasFinanceiras'])
            ->name('profile.financial-profile.metas');
    });

   
});


/*
|--------------------------------------------------------------------------
| API (JSON) – consumida pelo Vue/Axios
|--------------------------------------------------------------------------
*/

