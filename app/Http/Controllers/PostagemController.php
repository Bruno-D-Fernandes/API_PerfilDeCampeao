<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postagem;
use App\Models\Tag;
use App\Models\PostsImagem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

class PostagemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postagens = Postagem::with(['tags', 'imagens', 'usuario'])->get();
        return response()->json($postagens, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'textoPostagem' => 'required|string|max:255',
                'esporte_id' => 'required|integer|exists:esportes,id',
                'localizacaoPostagem' => 'nullable|string',
                'imagem' => 'nullable|image|max:2048',
            ]);

            $caminhoImagem = null;

            if ($request->hasFile('imagem')) {
                $caminhoImagem = $request->file('imagem')->store('postagens', 'public');
            }

            $postagem = Postagem::create([
                'idUsuario' => Auth()->id(), // Supondo que você tenha autenticação implementada | Isso com toda certeza eu vou ter que arrumar --ass: Bruno
                'textoPostagem' => $validatedData['textoPostagem'],
                'esporte_id' => $validatedData['esporte_id'],
                'localizacaoPostagem' => $validatedData['localizacaoPostagem'] ?? null,
            ]);


            if (!empty($validatedData['imagem']) && $caminhoImagem) {
                PostsImagem::create([
                    'idPostagem' => $postagem->id,
                    'caminhoImagem' => $caminhoImagem,
                ]);
            }

            return response()->json($postagem, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao criar postagem',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function showUserPosts($userId, $esporteId)
    {
        $postagens = Postagem::with(['imagens'])
            ->where('idUsuario', $userId)
            ->where('esporte_id', $esporteId)
            ->get();

        return response()->json($postagens, 200);
    }


    public function show(string $id)
    {
        $postagem = Postagem::with(['imagens'])->find($id);

        if (!$postagem) {
            return response()->json(['message' => 'Postagem não encontrada'], 404);
        }

        return response()->json($postagem, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, Request $request)
    {
        $postagem = Postagem::find($id);

        if (!$postagem) {
            return response()->json(['message' => 'Postagem não encontrada'], 404);
        }

        $validatedData = $request->validate([
            'textoPostagem' => 'sometimes|required|string|max:255',
            'localizacaoPostagem' => 'sometimes|nullable|string',
            'imagem' => 'sometimes|nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
            $imagemAntiga = $postagem->imagens()->first();
            if ($imagemAntiga) {
                Storage::disk('public')->delete($imagemAntiga->caminhoImagem);
                $imagemAntiga->delete();
            }

            $caminhoImagem = $request->file('imagem')->store('postagens', 'public');
            PostsImagem::create([
                'idPostagem' => $postagem->id,
                'caminhoImagem' => $caminhoImagem,
            ]);
        }

        $postagem->update($validatedData);

        return response()->json($postagem, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $postagem = Postagem::find($id);

        if (!$postagem) {
            return response()->json(['message' => 'Postagem não encontrada'], 404);
        }

        foreach ($postagem->imagens as $imagem) {
            Storage::disk('public')->delete($imagem->caminhoImagem);
            $imagem->delete();
        }

        $postagem->delete();

        return response()->json(['message' => 'Postagem deletada com sucesso'], 200);
    }
}