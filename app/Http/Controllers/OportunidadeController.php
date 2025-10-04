<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oportunidade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OportunidadeController extends Controller
{
    /**
     * Cria uma nova oportunidade (somente clube autenticado)
     */
    public function store(Request $request)
    {
       
        $validatedData = $request->validate([
            'descricaoOportunidades'    => 'required|string|max:255',
            'datapostagemOportunidades' => 'required|date',
            'esporte_id'                => 'required|exists:esportes,id',
            'posicoes_id'               => 'required|exists:posicoes,id',
        ]);
        
        
            if (!$clube) {
                return response()->json(['message' => 'Não autenticado'], 401);
            }

        try {
            
            $oportunidade = Oportunidade::create([
                'descricaoOportunidades'     => $validatedData['descricaoOportunidades'],
                'datapostagemOportunidades'  => $validatedData['datapostagemOportunidades'],
                'esporte_id'                 => $validatedData['esporte_id'],
                'posicoes_id'                => $validatedData['posicoes_id'],
                'clube_id'                   => $clube->id, // ID do clube autenticado
            ]);

            // 4. Sucesso!
            return response()->json($oportunidade, 201); 

        } catch (\Exception $e) {
            
            return response()->json([
                'error' => 'Erro interno ao criar oportunidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
}