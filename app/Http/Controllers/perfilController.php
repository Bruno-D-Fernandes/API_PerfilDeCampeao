<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;


class perfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perfis = Perfil::with(['usuario', 'categoria', 'posicoes', 'esporte', 'caracteristicas'])->get();
        return response()->json($perfis);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'categoria_id' => 'required|exists:categorias,id',
            'posicao_id' => 'nullable|exists:posicoes,id',
            'esporte_id' => 'required|exists:esportes,id',
            'caracteristicas' => 'array',
            'caracteristicas.*.id' => 'required|exists:caracteristicas,id',
            'caracteristicas.*.valor' => 'nullable|string|max:255',
            'posicoes' => 'array',
            'posicoes.*' => 'exists:posicoes,id',
        ]);

        $perfil = Perfil::create([
            'usuario_id' => $validated['usuario_id'],
            'categoria_id' => $validated['categoria_id'],
            'posicao_id' => $validated['posicao_id'] ?? null,
            'esporte_id' => $validated['esporte_id'],
        ]);

        if (!empty($validated['caracteristicas'])) {
            $caracteristicas = collect($validated['caracteristicas'])
                ->mapWithKeys(fn($c) => [$c['id'] => ['valor' => $c['valor'] ?? null]])
                ->toArray();
            $perfil->caracteristicas()->attach($caracteristicas);
        }

        if (!empty($validated['posicoes'])) {
            $perfil->posicoes()->attach($validated['posicoes']);
        }

        return response()->json([
            'message' => 'Perfil criado com sucesso!',
            'perfil' => $perfil->load(['usuario', 'categoria', 'posicoes', 'esporte', 'caracteristicas']),
        ], 201);
    }

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
