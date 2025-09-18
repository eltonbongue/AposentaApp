<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CustomNotification;
use App\Models\ChatQuestion;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        // Contadores simples
        $usersCount = User::count();
        $notificationsCount = CustomNotification::count();
        $chatQuestionsCount = ChatQuestion::count(); // total de perguntas no chatbot

        // Usuários criados por mês
        $usersPerMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        // Notificações por mês
        $notificationsPerMonth = CustomNotification::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        // Perguntas do chatbot por categoria
        $chatQuestionsByCategory = ChatQuestion::selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        return Inertia::render('admin/DashboardAdmin', [
            'stats' => [
                'users' => $usersCount,
                'notifications' => $notificationsCount,
                'chatQuestions' => $chatQuestionsCount, // total dinâmico
            ],
            'charts' => [
                'usersPerMonth' => $usersPerMonth,
                'notificationsPerMonth' => $notificationsPerMonth,
                'chatQuestionsByType' => $chatQuestionsByCategory, // gráfico dinâmico
            ],
        ]);
    }
}
