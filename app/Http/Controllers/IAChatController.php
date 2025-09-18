<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ChatQuestion;
use Illuminate\Support\Facades\Auth;

class IAChatController extends Controller
{
public function responder(Request $request)
{
    $mensagem = $request->validate([
        'mensagem' => 'required|string|max:1000',
    ])['mensagem'];

    $userId = Auth::id();

    Log::info('Chave da API Groq carregada:', ['key' => substr(env('GROQ_API_KEY'), 0, 10) . '...']);


    try {
$response = Http::withToken(env('GROQ_API_KEY'))
    ->timeout(30)
    ->post('https://api.groq.com/openai/v1/chat/completions', [
        'model' => 'llama-3.3-70b-versatile',
        'messages' => [
             [
                        'role' => 'system',
                        'content' => 'Você é um assistente de finanças pessoais focado na realidade angolana. Seja claro, educativo e acessível para todos os níveis de conhecimento.'
                    ],
                    ['role' => 'user', 'content' => $mensagem],
                ],
                'temperature' => 0.7,
                'max_completion_tokens' => 1000,
                'top_p' => 1.0,
                'stream' => false,
    ]);


        $respostaIA = $response->successful()
            ? data_get($response->json(), 'choices.0.message.content', 'A IA não conseguiu gerar resposta.')
            : 'Erro ao obter resposta. Status HTTP: ' . $response->status();

        // Salva a pergunta + resposta
        ChatQuestion::create([
            'user_id' => $userId,
            'question' => $mensagem,
            'response' => $respostaIA,
        ]);

        return response()->json(['success' => true, 'mensagem' => $mensagem, 'resposta' => $respostaIA]);
    } catch (\Exception $e) {
        Log::error('Erro IAChat', ['mensagem' => $mensagem, 'erro' => $e->getMessage()]);
        return response()->json(['success' => false, 'resposta' => 'Erro interno ao processar sua mensagem.'], 500);
    }
}

    }


