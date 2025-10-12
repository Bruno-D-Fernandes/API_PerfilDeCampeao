<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Clube;
use App\Models\Usuario;
use Illuminate\Http\Request;

class MembroClubeController extends Controller
{
    public function listarMembros(Request $request, string $clubeId)
    {
        try {
            if (auth('club_sanctum')->user()->id != $clubeId) {
                return response()->json(['message' => 'Somente o próprio clube pode listar seus membros'], 401);
            }

            $clube = Clube::findOrFail($clubeId);

            $perPage = $request->query('per_page', 15);
            $membros = $clube->membros()->paginate($perPage);

            return response()->json($membros, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao listar membros do clube',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function adicionarMembro(Request $request, string $clubeId, string $usuarioId,) {
        try {
            if ($clubeId != auth('club_sanctum')->user()->id) {
                return response()->json(['message' => 'Somente o próprio clube pode adicionar membros'], 401);
            }

            $clube = Clube::findOrFail($clubeId);

            $usuario = Usuario::findOrFail($usuarioId);

            $validatedData = $request->validate([
                'esporte_id' => 'required|exists:esportes,id',
                'funcao_id' => 'required|exists:funcoes,id'
            ]);

            $clube->membros()->attach($usuario->id, [
                'esporte_id' => $validatedData['esporte_id'],
                'funcao_id' => $validatedData['funcao_id']
            ]);

            return response()->json(['message' => 'Membro adicionado com sucesso'], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao adicionar membro do clube',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function removerMembro(Request $request, string $clubeId, string $usuarioId)
    {
        try {
            $clube = Clube::findOrFail($clubeId);

            if ($clubeId != auth('club_sanctum')->user()->id) {
                return response()->json(['message' => 'Somente o próprio clube pode adicionar membros'], 401);
            }

            $usuario = Usuario::findOrFail($usuarioId);

            $validatedData = $request->validate([
                'esporte_id' => 'required|exists:esportes,id',
                'funcao_id' => 'required|exists:funcoes,id',
            ]);

            $existe = $clube->membros()->wherePivot('esporte_id', $validatedData['esporte_id'])->wherePivot('funcao_id', $validatedData['funcao_id'])->exists();
        
            if (!$existe) {
                return response()->json(['message' => 'O clube não tem esse membro nessa função'], 409);
            }

            $clube->membros()
                ->wherePivot('esporte_id', $validatedData['esporte_id'])
                ->wherePivot('funcao_id', $validatedData['funcao_id'])
                ->detach($usuario->id);

            return response()->json(['message' => 'Membro removido com sucesso'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao remover membro do clube',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
