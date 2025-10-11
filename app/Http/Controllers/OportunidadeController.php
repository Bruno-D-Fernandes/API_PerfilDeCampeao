<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oportunidade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use App\Models\Clube;

class OportunidadeController extends Controller
{
    /**
     * Cria uma nova oportunidade (somente clube autenticado)
     */

    

    //ALGUEM ME AJUDA PELO AMOR DE DEUS --ASS: Luan


    public function store(Request $request)
    {
       
        $validatedData = $request->validate([
            'descricaoOportunidades'    => 'required|string|max:255',
            'datapostagemOportunidades' => 'required|date',
            'esporte_id'                => 'required|exists:esportes,id',
            'posicoes_id'               => 'required|exists:posicoes,id',
            'idadeMinima'               => 'nullable|integer|min:0|max:120',
            'idadeMaxima'               => 'nullable|integer|min:0|max:120|gte:idadeMinima',
            'estadoOportunidade'        => 'nullable|string|size:2',
            'cidadeOportunidade'        => 'nullable|string|max:100',
            'enderecoOportunidade'      => 'nullable|string|max:255',
            'cepOportunidade'           => 'nullable|string|max:9',
        ]);
        
        $clube = $request->user();

        try {
            
            $oportunidade = Oportunidade::create([
                'descricaoOportunidades'    => $validatedData['descricaoOportunidades'],
                'datapostagemOportunidades' => $validatedData['datapostagemOportunidades'],
                'esporte_id'                => $validatedData['esporte_id'],
                'posicoes_id'               => $validatedData['posicoes_id'],
                'clube_id'                  => $clube->id,
                'status'                    => Oportunidade::STATUS_PENDING,
                'idadeMinima'               => $validatedData['idadeMinima']        ?? null,
                'idadeMaxima'               => $validatedData['idadeMaxima']        ?? null,
                'estadoOportunidade'        => $validatedData['estadoOportunidade'] ?? null,
                'cidadeOportunidade'        => $validatedData['cidadeOportunidade'] ?? null,
                'enderecoOportunidade'      => $validatedData['enderecoOportunidade'] ?? null,
                'cepOportunidade'           => $validatedData['cepOportunidade']    ?? null,
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

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $oportunidades = Oportunidade::approved()->with(['esporte', 'posicao', 'clube'])->paginate($perPage);
        
        return response()->json($oportunidades, 200);
    }

    public function show($id)
    {
        $oportunidade = Oportunidade::approved()->with(['esporte', 'posicao', 'clube'])->find($id);

        if (!$oportunidade) {
            return response()->json(['message' => 'Oportunidade não encontrada'], 404);
        }

        return response()->json($oportunidade, 200);
    }

    public function update(Request $request, $id)
    {
        $oportunidade = Oportunidade::find($id);

        if (!$oportunidade) {
            return response()->json(['message' => 'Oportunidade não encontrada'], 404);
        }

        $clube = $request->user();
        if (!$clube || !($clube instanceof Clube) || $oportunidade->clube_id !== $clube->id) {
            return response()->json(['message' => 'Apenas o clube que criou a oportunidade pode atualizá-la'], 403);
        }

        $validatedData = $request->validate([
            'descricaoOportunidades'    => 'sometimes|required|string|max:255',
            'datapostagemOportunidades' => 'sometimes|required|date',
            'esporte_id'                => 'sometimes|required|exists:esportes,id',
            'posicoes_id'               => 'sometimes|required|exists:posicoes,id',
            'idadeMinima'               => 'sometimes|integer|min:0|max:120',
            'idadeMaxima'               => 'sometimes|integer|min:0|max:120|gte:idadeMinima',
            'estadoOportunidade'        => 'sometimes|string|size:2',
            'cidadeOportunidade'        => 'sometimes|string|max:100',
            'enderecoOportunidade'      => 'sometimes|string|max:255',
            'cepOportunidade'           => 'sometimes|string|max:9',
        ]);

         if ($oportunidade->status === Oportunidade::STATUS_REJECTED || $oportunidade->status === Oportunidade::STATUS_APPROVED) {
            $oportunidade->status = \App\Models\Oportunidade::STATUS_PENDING;
            $oportunidade->reviewed_by = null;
            $oportunidade->reviewed_at = null;
            $oportunidade->rejection_reason = null;
        }
        $oportunidade->fill($validatedData)->save();

        try {
            $oportunidade->update($validatedData);
            return response()->json([
            'message' => 'Oportunidade atualizada',
            'data'    => $oportunidade->load(['esporte','posicoes','clube']),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno ao atualizar oportunidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $oportunidade = Oportunidade::find($id);

        if (!$oportunidade) {
            return response()->json(['message' => 'Oportunidade não encontrada'], 404);
        }

        $clube = $request->user();
        if (!$clube || !($clube instanceof Clube) || $oportunidade->clube_id !== $clube->id) {
            return response()->json(['message' => 'Apenas o clube que criou a oportunidade pode deletá-la'], 403);
        }

        try {
            $oportunidade->delete();
            return response()->json(['message' => 'Oportunidade deletada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno ao deletar oportunidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
}