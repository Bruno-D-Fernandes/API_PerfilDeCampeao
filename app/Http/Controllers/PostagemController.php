<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            $validatedData = $request->validate([ // arrumar isso AQIOUIIIIIIIIIII
                'titulo' => 'required|string|max:255',
                'conteudo' => 'required|string',
                'imagem' => 'nullable|image|max:2048', // opcional, até 2MB
            ]);

            $caminhoImagem = null;

            if ($request->hasFile('imagem')) { // arrumar isso AQIOUIIIIIIIIIII
                // Salva o arquivo na pasta storage/app/public/postagens
                // e retorna o caminho relativo
                $caminhoImagem = $request->file('imagem')->store('postagens', 'public');
            }

            // Criar a postagem
            $postagem = Postagem::create([
                'titulo' => $validatedData['titulo'],
                'conteudo' => $validatedData['conteudo'],
                'imagem' => $caminhoImagem, // só salva o caminho no banco
            ]);

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
