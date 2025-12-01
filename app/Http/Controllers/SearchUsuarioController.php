<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Esporte;
use App\Models\Posicao;

class SearchUsuarioController extends Controller
{
    /**
     * Retorna a view principal para a carga inicial.
     */
    public function showPage(Request $request)
    {
        $perPage = 9; 

        $initialRequest = $request->duplicate();
        $initialRequest->merge(['per_page' => $perPage]);

        $atletas = $this->index($initialRequest, false);

        // BUSCA DADOS PARA OS SELECTS
        $esportes = Esporte::all(); 
        $posicoes = Posicao::all(); // Precisamos de todas para filtrar via JS no front

        return view('clube.pesquisa', [ 
            'atletas' => $atletas,
            'esportes' => $esportes,
            'posicoes' => $posicoes,
        ]);
    }

    /**
     * Endpoint AJAX para buscar atletas e retornar JSON.
     */
    public function index(Request $request, $isAjax = true)
    {
        $isAjaxCall = $isAjax || $request->ajax(); 
        
        $validatedData = $request->validate([
            'pesquisa'      => 'nullable|string|max:255',
            'esporte_id'    => 'nullable|integer',
            'posicao_id'    => 'nullable|integer', 
            'alturaCm'      => 'nullable|numeric|min:50|max:300',
            'altura_min'    => 'nullable|numeric|min:50|max:300',
            'altura_max'    => 'nullable|numeric|min:50|max:300',
            'peso_min'      => 'nullable|numeric|min:20|max:500',
            'peso_max'      => 'nullable|numeric|min:20|max:500',
            'idade_min'     => 'nullable|integer|min:0|max:120',
            'idade_max'     => 'nullable|integer|min:0|max:120',
            'estadoUsuario' => 'nullable|string|max:100',
            'cidadeUsuario' => 'nullable|string|max:100',
            'peDominante'   => 'nullable|in:direito,esquerdo',
            'maoDominante'  => 'nullable|in:destro,canhoto',
            'page'          => 'nullable|integer',
            'ordenarpor'    => 'nullable|string',
        ]);

        $perPage = 9;
        $sort = $request->input('ordenarpor', 'recentes');
        $direction = 'desc';

        $q = Usuario::query()
            ->with(['posicoes:id,nomePosicao', 'perfis.esporte']); 

        // --- FILTROS ---

        if (!empty($validatedData['pesquisa'])) {
            $term = $validatedData['pesquisa'];
            $q->where(function ($w) use ($term) {
                 $w->where('nomeCompletoUsuario', 'like', "%{$term}%")
                   ->orWhere('emailUsuario', 'like', "%{$term}%");
            });
        }

        if (!empty($validatedData['posicao_id'])) {
            $q->whereHas('posicoes', fn ($w) => $w->where('posicoes.id', $validatedData['posicao_id']));
        }

        if (!empty($validatedData['esporte_id'])) {
            $q->whereHas('perfis.esporte', fn ($w) => $w->where('esportes.id', $validatedData['esporte_id']));
        }

        // Filtros de Ranges
        if (!empty($validatedData['altura_min'])) $q->where('alturaCm', '>=', $validatedData['altura_min']);
        if (!empty($validatedData['altura_max'])) $q->where('alturaCm', '<=', $validatedData['altura_max']);
        
        if (!empty($validatedData['peso_min'])) $q->where('pesoKg', '>=', $validatedData['peso_min']);
        if (!empty($validatedData['peso_max'])) $q->where('pesoKg', '<=', $validatedData['peso_max']);

        if (!empty($validatedData['idade_min'])) {
            $q->where('dataNascimentoUsuario', '<=', now()->subYears($validatedData['idade_min'])->endOfDay());
        }
        if (!empty($validatedData['idade_max'])) {
            $q->where('dataNascimentoUsuario', '>=', now()->subYears($validatedData['idade_max'])->startOfDay());
        }

        // Filtros Específicos
        if (!empty($validatedData['peDominante'])) $q->where('peDominante', $validatedData['peDominante']);
        if (!empty($validatedData['maoDominante'])) $q->where('maoDominante', $validatedData['maoDominante']);
        if (!empty($validatedData['estadoUsuario'])) $q->where('estadoUsuario', $validatedData['estadoUsuario']);
        if (!empty($validatedData['cidadeUsuario'])) $q->where('cidadeUsuario', $validatedData['cidadeUsuario']);

        // Ordenação
        switch ($sort) {
            case 'altura': $q->orderBy('alturaCm', $direction); break;
            case 'peso': $q->orderBy('pesoKg', $direction); break;
            case 'idade': $q->orderBy('dataNascimentoUsuario', 'asc'); break;
            case 'nome': $q->orderBy('nomeCompletoUsuario', 'asc'); break;
            default: $q->orderBy('updated_at', 'desc'); break;
        }

        $result = $q->paginate($perPage)->appends($request->query());

        if (!$isAjaxCall) {
            return $result;
        }

        return response()->json([
            'grid' => view('clube.partials.athletes-grid', ['atletas' => $result])->render(),
            'pagination' => view('clube.partials.pagination', ['atletas' => $result])->render(),
            'total' => $result->total(),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
