<?php

namespace App\Http\Controllers;

use App\Models\FinancialProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialProfileController extends Controller
{
    public function show()
    {
        $profile = Auth::user()->financialProfile;
        return response()->json($profile);
    }

    public function store(Request $request)
    {
        $request->validate([
            'salario_actual' => 'required|numeric',
            'poupanca' => 'required|numeric',
            'investimentos' => 'nullable|numeric',
            'montante_aposentadoria' => 'required|numeric',
            'idade_aposentadoria' => 'required|integer',
        ]);

        $profile = FinancialProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only([
                'salario_actual',
                'poupanca',
                'investimentos',
                'montante_aposentadoria',
                'idade_aposentadoria'
            ])
        );

        return response()->json($profile, 200);
    }
}
