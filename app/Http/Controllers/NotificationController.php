<?php

namespace App\Http\Controllers;

use App\Models\CustomNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    /**
     * Página de notificações do usuário (Inertia).
     */
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->customNotifications()
            ->latest()
            ->get();

        return Inertia::render('Notifications', [
            'notifications' => $notifications,
            'unreadCount'   => $notifications->where('lida', false)->count(),
        ]);
    }

    /**
     * Admin vê a tela de notificações.
     */
    public function adminIndex()
    {
        $notifications = CustomNotification::latest()
            ->with('user:id,name,email')
            ->get();

        return Inertia::render('admin/NotificationsScreen', [
            'users'         => User::select('id', 'name', 'email')->get(),
            'notifications' => $notifications,
        ]);
    }

    /**
     * API – Lista notificações do usuário autenticado (JSON).
     */
    public function apiIndex()
    {
        $user = Auth::user();

        $notifications = $user->customNotifications()
            ->latest()
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $notifications->where('lida', false)->count(),
        ]);
    }

    /**
     * Marca uma notificação como lida.
     */
    public function markAsRead(CustomNotification $notification)
    {
        if (!$notification->lida) {
            $notification->update(['lida' => true]);
        }

        $unreadCount = Auth::user()
            ->customNotifications()
            ->where('lida', false)
            ->count();

        return response()->json([
            'success'      => true,
            'mensagem'     => 'Notificação marcada como lida',
            'data'         => $notification,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Admin envia notificação (para 1 ou todos os usuários).
     */
    public function store(Request $request)
    {
        $request->validate([
            'mensagem' => 'required|string|max:1000',
            'user_id'  => 'nullable|exists:users,id',
        ]);

        // Notificação individual
        if ($request->filled('user_id')) {
            CustomNotification::create([
                'user_id'  => $request->user_id,
                'mensagem' => $request->mensagem,
                'lida'     => false,
            ]);

            return Inertia::render('admin/NotificationsScreen', [
                'users'         => User::select('id', 'name', 'email')->get(),
                'notifications' => CustomNotification::latest()->get(),
                'successMessage' => 'Notificação enviada ao usuário.',
            ]);
        }

        // Notificação para todos
        $notificacoes = User::pluck('id')->map(fn($id) => [
            'user_id'    => $id,
            'mensagem'   => $request->mensagem,
            'lida'       => false,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        CustomNotification::insert($notificacoes);

        return Inertia::render('admin/NotificationsScreen', [
            'users'         => User::select('id', 'name', 'email')->get(),
            'notifications' => CustomNotification::latest()->get(),
            'successMessage' => 'Notificação enviada a todos os usuários.',
        ]);
    }

    /**
     * Exclui uma notificação do usuário autenticado ou admin.
     */
    public function destroy(CustomNotification $notification)
    {
        // Exclui a notificação
        $notification->delete();

        // Após a exclusão, retorna uma resposta Inertia para atualizar a página sem recarregar
        return Inertia::render('admin/NotificationsScreen', [
            'users'         => User::select('id', 'name', 'email')->get(),
            'notifications' => CustomNotification::latest()->get(),
            'successMessage' => 'Notificação removida com sucesso!',
        ]);
    }
}
