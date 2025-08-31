<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Profile\FinancialProfileController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| 🌐 ROTA PÚBLICA
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

/*
|--------------------------------------------------------------------------
| 🔐 ROTAS ADMIN (protegidas, mas separadas se necessário)
|--------------------------------------------------------------------------
*/
 Route::get('/admin/dashboard', fn() => Inertia::render('admin/DashboardAdmin'))
        ->name('admin.dashboard');
 Route::get('/admin/users', fn() => Inertia::render('admin/UsersScreen'))
        ->name('admin.users');
 Route::get('/admin/notificacoes', fn() => Inertia::render('admin/NotificationsScreen'))
        ->name('admin.notificacoes');        


/*
|--------------------------------------------------------------------------
| 🔐 ROTAS PROTEGIDAS SPA (usuário comum)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    // Outras páginas
    Route::get('/calculateamount', fn() => Inertia::render('CalculateAmount'))->name('calculateamount');
    Route::get('/financechat', fn() => Inertia::render('FinanceChat'))->name('financechat');
    Route::get('/notificacoes', fn() => Inertia::render('Notifications'))->name('notificacoes');

    // Perfil financeiro (consumido via Axios)
    Route::prefix('/profile')->group(function () {
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
| 🔌 API RESTFUL (consumida por Vue Axios ou apps externos)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'verified'])->prefix('api')->group(function () {


    // Notificações
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
});
