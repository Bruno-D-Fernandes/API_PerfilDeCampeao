<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;
use App\Models\Categoria;
use App\Models\Posicao;
use App\Models\Caracteristica;
use App\Models\Esporte;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;


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

    public function esportesFiltro()
    {
        $user = Auth::user();

        $esportesJaTem = $user->perfis->pluck('esporte_id')->toArray();
        $esportes = Esporte::whereNotIn('id', $esportesJaTem)->get();

        return response()->json($esportes);
    }

    public function formInfo($id)
    {
        $categorias = Categoria::all();

        $posicoes = [];
        $caracteristicas = [];

        $posicoes = Posicao::where('idEsporte', $id)->get();
        $caracteristicas = Caracteristica::where('esporte_id', $id)->get();

        return response()->json([
            'categorias' => $categorias,
            'posicoes' => $posicoes,
            'caracteristicas' => $caracteristicas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'categoria_id' => 'required|exists:categorias,id',
            'esporte_id' => 'required|exists:esportes,id',
            'caracteristicas' => 'array',
            'caracteristicas.*.id' => 'required|exists:caracteristicas,id',
            'caracteristicas.*.valor' => 'nullable|max:255',
            'posicao_id' => 'required|exists:posicoes,id',
            'posicoes' => 'array',
            'posicoes.*' => 'exists:posicoes,id',
        ]);

        $perfil = Perfil::create([
            'usuario_id' => $validated['usuario_id'],
            'categoria_id' => $validated['categoria_id'],
            'esporte_id' => $validated['esporte_id'],
            'posicao_id' => $validated['posicao_id'],
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
    public function show()
    {
        $usuario = Auth::user();
        $usuario->load([
            'perfis.categoria',
            'perfis.posicoes',
            'perfis.esporte',
            'perfis.caracteristicas'
        ]);

        $perfisAgrupados = $usuario->perfis->groupBy(function ($perfil) {
            return $perfil->esporte->nomeEsporte ?? 'Sem esporte';
        });

        return response()->json($perfisAgrupados);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $perfil = Perfil::findOrFail($id);

        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'esporte_id' => 'required|exists:esportes,id',
            'caracteristicas' => 'array',
            'caracteristicas.*.id' => 'required|exists:caracteristicas,id',
            'caracteristicas.*.valor' => 'nullable|max:255',
            'posicoes' => 'array',
            'posicoes.*' => 'exists:posicoes,id',
        ]);

        $perfil->update([
            'categoria_id' => $validated['categoria_id'],
            'esporte_id' => $validated['esporte_id'],
        ]);

        if (isset($validated['caracteristicas'])) {
            $caracteristicas = collect($validated['caracteristicas'])
                ->mapWithKeys(fn($c) => [$c['id'] => ['valor' => $c['valor'] ?? null]])
                ->toArray();

            $perfil->caracteristicas()->sync($caracteristicas);
        }

        if (isset($validated['posicoes'])) {
            $perfil->posicoes()->sync($validated['posicoes']);
        }

        return response()->json([
            'message' => 'Perfil atualizado com sucesso!',
            'perfil' => $perfil->load(['usuario', 'categoria', 'posicoes', 'esporte', 'caracteristicas']),
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $perfil = Perfil::findOrFail($id);

        $perfil->posicoes()->detach();
        $perfil->caracteristicas()->detach();

        $perfil->delete();

        return response()->json([
            'message' => 'Perfil excluído com sucesso!'
        ], 200);
    }
}
