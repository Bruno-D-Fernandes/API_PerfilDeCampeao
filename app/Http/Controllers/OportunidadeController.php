<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oportunidade;
use Illuminate\Support\Facades\Auth;

class OportunidadeController extends Controller
{
    /**
     * Lista todas as oportunidades (visíveis para os usuários)
     */
    public function index()
    {
        try {
            $oportunidades = Oportunidade::with(['clube', 'esporte', 'posicao'])
                ->orderBy('datapostagemOportunidades', 'desc')
                ->get();

            return response()->json($oportunidades, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao buscar oportunidades',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cria uma nova oportunidade (somente clube autenticado)
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'descricaoOportunidades' => 'required|string|max:255',
                'posicaoOportunidades'   => 'required|string|max:255',
                'datapostagemOportunidades' => 'required|date',
                'esporte_id'             => 'required|exists:esportes,id',
                'posicoes_id'            => 'required|exists:posicoes,id',
            ]);

            // Pega o clube logado (ajuste dependendo da autenticação) || ISSO ESTA MUITO ERRADO, Vou mexer nisso depois --Ass: Luan
            $clubeId = Auth::id(); 

            $oportunidade = Oportunidade::create([
                'descricaoOportunidades'     => $validatedData['descricaoOportunidades'],
                'posicaoOportunidades'       => $validatedData['posicaoOportunidades'],
                'datapostagemOportunidades'  => $validatedData['datapostagemOportunidades'],
                'esporte_id'                 => $validatedData['esporte_id'],
                'posicoes_id'                => $validatedData['posicoes_id'],
                'clube_id'                   => $clubeId,
            ]);

            return response()->json($oportunidade, 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao criar oportunidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibe uma oportunidade específica
     */
    public function show($id)
    {
        try {
            $oportunidade = Oportunidade::with(['clube', 'esporte', 'posicao'])
                ->findOrFail($id);

            return response()->json($oportunidade, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Oportunidade não encontrada',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Atualiza uma oportunidade (somente o clube dono da vaga)
     */
    public function update(Request $request, $id)
    {
        try {
            $oportunidade = Oportunidade::findOrFail($id);

            // Confirma que o clube dono é o mesmo logado
            if ($oportunidade->clube_id !== Auth::id()) {
                return response()->json(['error' => 'Não autorizado'], 403);
            }

            $validatedData = $request->validate([
                'descricaoOportunidades' => 'sometimes|required|string|max:255',
                'posicaoOportunidades'   => 'sometimes|required|string|max:255',
                'datapostagemOportunidades' => 'sometimes|required|date',
                'esporte_id'             => 'sometimes|required|exists:esportes,id',
                'posicoes_id'            => 'sometimes|required|exists:posicoes,id',
            ]);

            $oportunidade->update($validatedData);

            return response()->json($oportunidade, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao atualizar oportunidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deleta uma oportunidade (somente o clube dono da vaga)
     */
    public function destroy($id)
    {
        try {
            $oportunidade = Oportunidade::findOrFail($id);

            if ($oportunidade->clube_id !== Auth::id()) {
                return response()->json(['error' => 'Não autorizado'], 403);
            }

            $oportunidade->delete();

            return response()->json(['message' => 'Oportunidade excluída com sucesso'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao excluir oportunidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
