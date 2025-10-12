<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lista;
use App\Models\Clube;
use App\Models\Usuario;

class ListaClubeController extends Controller
{
    // POST /api/clube/listas
    public function store(Request $request)
    {
        $clube = $request->user();
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Apenas clube autenticado'], 403);
        }

        $data = $request->validate([
            'nomeLista'       => 'required|string|max:255',
            'descricaoLista'  => 'nullable|string|max:255',
        ]);

        $existe = Lista::where('clube_id', $clube->id)->where('nomeLista', $data['nomeLista'])->exists();
        if ($existe) {
            return response()->json(['message' => 'Já existe uma lista com esse nome'], 422);
        }

        $lista = Lista::create([
            'clube_id'  => $clube->id,      
            'nomeLista'      => $data['nomeLista'],
            'descricaoLista' => $data['descricaoLista'] ?? null,
        ]);

        return response()->json(['message' => 'Lista criada com sucesso', 'data' => $lista], 201);
    }

    // POST /api/clube/listas/{listaId}/usuarios
    public function addUsuarioToLista(Request $request, $listaId)
    {
        $clube = $request->user();
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Apenas clube autenticado'], 403);
        }

        $data = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $lista = Lista::where('clube_id', $clube->id)->findOrFail($listaId);

        // evita duplicatas no pivot
        $lista->usuarios()->syncWithoutDetaching([$data['usuario_id']]);

        return response()->json(['message' => 'Usuário adicionado à lista com sucesso'], 201);
    }

    // DELETE /api/clube/listas/{listaId}/usuarios
    public function removeUsuarioFromLista(Request $request, $listaId)
    {
        $clube = $request->user();
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Apenas clube autenticado'], 403);
        }

        $data = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $lista = Lista::where('clube_id', $clube->id)->findOrFail($listaId);
        $lista->usuarios()->detach($data['usuario_id']); // idempotente

        return response()->json(['message' => 'Usuário removido da lista com sucesso'], 200);
    }

    // GET /api/clube/listas/{id}
    public function show(Request $request, $id)
    {
        $clube = $request->user();
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Apenas clube autenticado'], 403);
        }

        $lista = Lista::where('clube_id', $clube->id)
            ->with(['usuarios:id,nomeCompletoUsuario,emailUsuario,estadoUsuario,cidadeUsuario,alturaCm,pesoKg'])
            ->findOrFail($id);

        return response()->json($lista);
    }
}
