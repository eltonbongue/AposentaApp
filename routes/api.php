<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IAChatController;
use App\Http\Controllers\NotificationController;

Route::post('/chat/ia', [IAChatController::class, 'responder'])->name('chat.ia');

// API protegida – Notificações
//Rota pública para deletar notificações ()

 Route::get('/notifications', [NotificationController::class, 'apiIndex'])->name('api.notifications');
 Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('api.notifications.read');
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('api.notifications.destroy');

 
// Retorna o usuário autenticado
Route::get('/user', function (Request $request) {
    return $request->user();
});
