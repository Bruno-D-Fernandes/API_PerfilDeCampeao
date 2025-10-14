<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postagem;
use App\Models\Tag;
use App\Models\PostsImagem;
use Illuminate\Support\Facades\Auth;

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
            // Validação do request
            $validatedData = $request->validate([
                'textoPostagem' => 'required|string|max:255',
                'localizacaoPostagem' => 'nullable|string',
                'tags' => 'nullable|array',
                'tags.*' => 'string|max:10',
                'imagem' => 'nullable|image|max:2048', // opcional, até 2MB
            ]);

            $caminhoImagem = null;

            if ($request->hasFile('imagem')) { 
                $caminhoImagem = $request->file('imagem')->store('postagens', 'public'); // Mudar o diretório depois para ficar mais organizado --ass: Bruno
            }

            $postagem = Postagem::create([
                'idUsuario' => Auth()->id(), // Supondo que você tenha autenticação implementada | Isso com toda certeza eu vou ter que arrumar --ass: Bruno
                'textoPostagem' => $validatedData['textoPostagem'],
                'localizacaoPostagem' => $validatedData['localizacaoPostagem'] ?? null,
            ]);

            if (!empty($validatedData['imagem']) && $caminhoImagem) {
                PostsImagem::create([
                    'idPostagem' => $postagem->id,
                    'caminhoImagem' => $caminhoImagem,
                ]);
            }
            if (!empty($validatedData['tags'])) {
                $tagIds = [];
                foreach ($validatedData['tags'] as $nomeTag) {
                    $tag = Tag::firstOrCreate(['nomeTag' => $nomeTag]);
                    $tagIds[] = $tag->id;
                }
                $postagem->tags()->sync($tagIds);
            }


            return response()->json($postagem, 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao criar postagem',
                'message' => $e->getMessage()
            ], 500);
        }
    } // php artisan storage:link


    public function showUserPosts($userId)
    {
        $postagens = Postagem::with(['tags', 'imagens', 'usuario'])
            ->where('idUsuario', $userId)
            ->get();

        return response()->json($postagens, 200);
    }
    
    public function show(string $id)
    {
        $postagem = Postagem::with(['tags', 'imagens', 'usuario'])->find($id);

        if (!$postagem) {
            return response()->json(['message' => 'Postagem não encontrada'], 404);
        }

        return response()->json($postagem, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $postagem = Postagem::find($id);

        if (!$postagem) {
            return response()->json(['message' => 'Postagem não encontrada'], 404);
        }

        $validatedData = $request->validate([
            'textoPostagem' => 'sometimes|required|string|max:255',
            'localizacaoPostagem' => 'sometimes|nullable|string',
            'tags' => 'sometimes|nullable|array',
            'tags.*' => 'string|max:10',
            'imagem' => 'sometimes|nullable|image|max:2048', // opcional, até 2MB
        ]);

        if ($request->hasFile('imagem')) {
            // Deleta a imagem antiga se existir
            $imagemAntiga = $postagem->imagens()->first();
            if ($imagemAntiga) {
                Storage::disk('public')->delete($imagemAntiga->caminhoImagem);
                $imagemAntiga->delete();
            }

            // Armazena a nova imagem
            $caminhoImagem = $request->file('imagem')->store('postagens', 'public');
            PostsImagem::create([
                'idPostagem' => $postagem->id,
                'caminhoImagem' => $caminhoImagem,
            ]);
        }

        $postagem->update($validatedData);

        if (array_key_exists('tags', $validatedData)) {
            if (!empty($validatedData['tags'])) {
                $tagIds = [];
                foreach ($validatedData['tags'] as $nomeTag) {
                    $tag = Tag::firstOrCreate(['nomeTag' => $nomeTag]);
                    $tagIds[] = $tag->id;
                }
                $postagem->tags()->sync($tagIds);
            } else {
                // Se o array de tags estiver vazio, desvincula todas as tags
                $postagem->tags()->detach();
            }
        }

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

        // Deleta imagens associadas
        foreach ($postagem->imagens as $imagem) {
            Storage::disk('public')->delete($imagem->caminhoImagem);
            $imagem->delete();
        }

        // Desvincula tags associadas
        $postagem->tags()->detach();

        $postagem->delete();

        return response()->json(['message' => 'Postagem deletada com sucesso'], 200);
    }
}
