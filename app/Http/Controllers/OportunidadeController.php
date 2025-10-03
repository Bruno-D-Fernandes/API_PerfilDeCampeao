<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oportunidade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OportunidadeController extends Controller
{
    /**
     * Lista todas as oportunidades (visíveis para os usuários)
     */
    public function index()
    {
        try {
           $oportunidades = Oportunidade::orderBy('datapostagemOportunidades', 'desc')->get();
            // Incluindo os relacionamentos (opcional, mas bom para o front-end)
            $oportunidades = Oportunidade::with(['clube', 'esporte', 'posicoes'])
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
       
        $validatedData = $request->validate([
            'descricaoOportunidades'    => 'required|string|max:255',
            'datapostagemOportunidades' => 'required|date',
            'esporte_id'                => 'required|exists:esportes,id',
            'posicoes_id'               => 'required|exists:posicoes,id',
        ]);
        

        // TEM MUITA COISA ERRADA AQUI, IREI ARRUMAR --Assim que arrumar, irei comentar o que foi alterado --Ass: Luan
      
        $clube = auth('sanctum')->user();

        if (!$clube) {
            return response()->json(['error' => 'Não autenticado como Clube'], 401);
        }

        try {
            
            $oportunidade = Oportunidade::create([
                'descricaoOportunidades'     => $validatedData['descricaoOportunidades'],
                'datapostagemOportunidades'  => $validatedData['datapostagemOportunidades'],
                'esporte_id'                 => $validatedData['esporte_id'],
                'posicoes_id'                => $validatedData['posicoes_id'],
                'clube_id'                   => $clube->id, // Usando o ID do Clube logado
            ]);

            return response()->json($oportunidade, 201); // Retorno correto para criação

        } catch (\Exception $e) {
            // Captura erros de banco de dados ou outros erros de criação
            return response()->json([
                'error' => 'Erro interno ao criar oportunidade',
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
            $oportunidade = Oportunidade::with(['clube', 'esporte', 'posicoes']) // Corrigido 'posicao' para 'posicoes' (nome do relacionamento no Model)
                ->findOrFail($id);

            return response()->json($oportunidade, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Oportunidade não encontrada',
                'message' => 'Oportunidade com ID ' . $id . ' não existe.'
            ], 404);
        }
    }

    /**
     * Atualiza uma oportunidade (somente o clube dono da vaga)
     */
    public function update(Request $request, $id)
    {
        // 1. Encontra a oportunidade e trata 404
        $oportunidade = Oportunidade::findOrFail($id);
        
        // 2. Confirmação de Autorização (403 Forbidden)
        if ($oportunidade->clube_id !== Auth::id()) {
            return response()->json(['error' => 'Acesso negado', 'message' => 'Você não é o clube criador desta oportunidade.'], 403);
        }

        // 3. Validação (Se falhar, Laravel retorna 422)
        $validatedData = $request->validate([
            'descricaoOportunidades'    => 'sometimes|required|string|max:255',
            'posicaoOportunidades'      => 'sometimes|required|string|max:255',
            'datapostagemOportunidades' => 'sometimes|required|date',
            'esporte_id'                => 'sometimes|required|exists:esportes,id',
            'posicoes_id'               => 'sometimes|required|exists:posicoes,id',
        ]);

        try {
            // 4. Atualização
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
        // 1. Encontra a oportunidade e trata 404
        $oportunidade = Oportunidade::findOrFail($id);

        // 2. Confirmação de Autorização (403 Forbidden)
        if ($oportunidade->clube_id !== Auth::id()) {
            return response()->json(['error' => 'Acesso negado', 'message' => 'Você não é o clube criador desta oportunidade.'], 403);
        }

        try {
            // 3. Deleção
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