<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postagem;
use App\Models\Tag;
use App\Models\PostsImagem;

use Illuminate\Support\Facades\Storage;

class PostagemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
                'idUsuario' => auth()->id(), // Supondo que você tenha autenticação implementada | Isso com toda certeza eu vou ter que arrumar --ass: Bruno
                'textoPostagem' => $validatedData['textoPostagem'],
                'localizacaoPostagem' => $validatedData['localizacaoPostagem'] ?? null,
            ]);

            if (!empty($validatedData['imagem']) && $caminhoImagem) {
                PostsImagem::create([
                    'idPostagem' => $postagem->id,
                    'caminhoImagem' => $caminhoImagem,
                ]);
            }
            if (!empty($validatedData['tags'])) { // Deus me proteja desse logica --ass: Bruno
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


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
