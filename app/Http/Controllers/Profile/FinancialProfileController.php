<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FinancialProfile;
use Illuminate\Support\Facades\Log;

class FinancialProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Retorna o perfil financeiro do usuário autenticado.
     */
    public function show()
    {
        $user = Auth::user();

        if (!$user->financialProfile) {
            return response()->json([
                'message' => 'Perfil financeiro ainda não foi criado.',
                'financialProfile' => null,
            ], 200);
        }

        return response()->json([
            'financialProfile' => $user->financialProfile,
        ]);
    }

    /**
     * Atualiza ou cria o perfil financeiro do usuário autenticado.
     */
    public function update(Request $request)
    {
        try {
            // Validação dos dados recebidos
            $validated = $request->validate([
                'salario_actual' => ['required', 'numeric', 'min:0'],
                'poupanca' => ['required', 'numeric', 'min:0'],
                'investimentos' => ['required', 'numeric', 'min:0'],
                'montante_aposentadoria' => ['required', 'numeric', 'min:0'],
                'idade_aposentadoria' => ['required', 'integer', 'min:18', 'max:100'],
                'idade_actual' => ['required', 'integer', 'min:18', 'max:100'],
                'duracao_aposentadoria' => ['required', 'integer', 'min:1', 'max:100'],
                'retorno_investimento_anual' => ['required', 'numeric', 'min:0'],
                'inflacao_anual' => ['required', 'numeric', 'min:0'],
            ]);

            // Validação lógica extra
            if ($validated['idade_aposentadoria'] <= $validated['idade_actual']) {
                return response()->json([
                    'message' => 'A idade para aposentadoria deve ser maior que a idade atual.'
                ], 422);
            }

            $user = Auth::user();

            $financialProfile = FinancialProfile::updateOrCreate(
                ['user_id' => $user->id],
                $validated
            );

            return response()->json([
                'success' => true,
                'message' => 'Perfil financeiro atualizado com sucesso.',
                'financialProfile' => $financialProfile,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao atualizar perfil financeiro: ' . $e->getMessage());

            return response()->json([
                'message' => 'Erro interno no servidor. Tente novamente mais tarde.',
            ], 500);
        }
    }

    /**
     * Calcula e retorna as metas financeiras do usuário.
     */
    public function getMetasFinanceiras()
    {
        $user = Auth::user();
        $profile = $user->financialProfile;

        if (!$profile) {
            return response()->json([
                'error' => 'Perfil financeiro não encontrado.',
            ], 404);
        }

        $metaAnual   = $profile->montante_aposentadoria;
        $metaMensal  = $metaAnual / 12;
        $metaSemanal = $metaAnual / 52;

        $saldo = $profile->poupanca + $profile->investimentos;

        $progressoPercentual = $metaAnual > 0 ? ($saldo / $metaAnual) * 100 : 0;

        return response()->json([
            'meta_anual'    => round($metaAnual, 2),
            'meta_mensal'   => round($metaMensal, 2),
            'meta_semanal'  => round($metaSemanal, 2),
            'saldo'         => round($saldo, 2),
            'progresso'     => round($progressoPercentual, 1), // exemplo: 55.3%
        ]);
    }
}
