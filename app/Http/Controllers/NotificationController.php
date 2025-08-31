<?php

namespace App\Http\Controllers;

use App\Models\CustomNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    // Lista notificações do usuário autenticado
    public function index()
    {
        $notifications = Auth::user()->customNotifications()->latest()->get();
        return response()->json($notifications);
    }

    // Marca uma notificação como lida
    public function markAsRead(CustomNotification $notification)
    {
        if ($notification->user_id === Auth::id()) {
            $notification->update(['lida' => true]);
        }

        return response()->json(['success' => true]);
    }

    // Admin envia notificação
    public function store(Request $request)
    {
        $request->validate([
            'mensagem' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($request->user_id) {
            CustomNotification::create([
                'user_id' => $request->user_id,
                'mensagem' => $request->mensagem,
                'lida' => false,
            ]);
        } else {
            // Envia para todos os usuários
            $users = User::all();
            foreach ($users as $user) {
                CustomNotification::create([
                    'user_id' => $user->id,
                    'mensagem' => $request->mensagem,
                    'lida' => false,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
