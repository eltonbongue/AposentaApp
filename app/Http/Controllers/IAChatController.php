<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IAChatController extends Controller
{
    public function responder(Request $request)
    {
        $mensagem = $request->input('mensagem');

        if (!$mensagem) {
            return response()->json(['resposta' => 'Mensagem vazia.'], 400);
        }

        $response = Http::withToken(env('GROQ_API_KEY')) // utilize a chave da Gloq
            ->timeout(30)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile', // ajuste para o modelo disponível que desejar
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

        if ($response->failed()) {
            $errorData = $response->json();
            Log::error('Erro na API Gloq', [
                'status' => $response->status(),
                'resposta_api' => $errorData
            ]);

            return response()->json([
                'resposta' => $errorData['error']['message'] ?? 'Falha ao comunicar com a API da Gloq.',
                'debug' => $errorData
            ], $response->status());
        }

        $data = $response->json();

        if (!isset($data['choices'][0]['message']['content'])) {
            return response()->json([
                'resposta' => 'A IA não conseguiu gerar resposta para sua pergunta.',
                'debug' => $data
            ], 400);
        }

        return response()->json([
            'resposta' => $data['choices'][0]['message']['content']
        ]);
    }
}
