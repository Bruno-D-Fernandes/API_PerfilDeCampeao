<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class SearchUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $validatedData = $request->validate([
        'pesquisa'        => 'nullable|string|max:255',

        
        'posicao_id'      => 'nullable|integer|exists:posicoes,id',

        // Altura (em cm ou m) + ranges
        'alturaCm'        => 'nullable|numeric|min:50|max:300',
        'altura_m'        => 'nullable|numeric|min:0.5|max:3.0',
        'altura_min'      => 'nullable|numeric|min:50|max:300',
        'altura_max'      => 'nullable|numeric|min:50|max:300',

        // Peso (kg) + ranges
        'pesoKg'          => 'nullable|numeric|min:20|max:500',
        'peso_min'        => 'nullable|numeric|min:20|max:500',
        'peso_max'        => 'nullable|numeric|min:20|max:500',

        // Idade (anos)
        'idade'           => 'nullable|integer|min:0|max:120',
        'idade_min'       => 'nullable|integer|min:0|max:120',
        'idade_max'       => 'nullable|integer|min:0|max:120',

        // Localização e dominância
        'estadoUsuario'   => 'nullable|string|max:100',
        'cidadeUsuario'   => 'nullable|string|max:100',
        'peDominante'     => 'nullable|in:direito,esquerdo',
        'maoDominante'    => 'nullable|in:destro,canhoto',

        // Paginação & ordenação
        'per_page'        => 'nullable|integer|min:1|max:100',
        'page'            => 'nullable|integer|min:1',
        'ordenarpor'      => 'nullable|string|in:recentes,altura,peso,idade,nome,todos', // inclui "todos" p/ compatibilidade
        'direction'       => 'nullable|in:asc,desc',
    ]);

   
    if (!empty($validatedData['altura_m']) && empty($validatedData['alturaCm'])) {
        $validatedData['alturaCm'] = (int) round($validatedData['altura_m'] * 100);
    }

    
    $perPage   = isset($validatedData['per_page']) ? min(max((int) $validatedData['per_page'], 1), 100) : 15;
    $sort      = $validatedData['ordenarpor'] ?? 'recentes';
    $direction = $validatedData['direction']  ?? 'desc';

    
    $q = Usuario::query()
        ->select([
            'id',
            'nomeCompletoUsuario',
            'emailUsuario',
            'dataNascimentoUsuario',
            'cidadeUsuario',
            'estadoUsuario',
            'alturaCm',
            'pesoKg',
            'peDominante',
            'maoDominante',
            'created_at',
            'updated_at',
        ])
        ->with(['posicoes:id,nomePosicao']);

   
    if (!empty($validatedData['pesquisa'])) {
        $s = $validatedData['pesquisa'];
        $q->where(function ($w) use ($s) {
            $w->where('nomeCompletoUsuario', 'like', "%{$s}%")
              ->orWhere('emailUsuario', 'like', "%{$s}%");
        });
    }

    

   
    if (!empty($validatedData['posicao_id'])) {
        $q->whereHas('posicoes', fn ($w) => $w->where('posicoes.id', $validatedData['posicao_id']));
    
    }

   
    if (!empty($validatedData['alturaCm']))   $q->where('alturaCm', $validatedData['alturaCm']);
    if (!empty($validatedData['altura_min'])) $q->where('alturaCm', '>=', $validatedData['altura_min']);
    if (!empty($validatedData['altura_max'])) $q->where('alturaCm', '<=', $validatedData['altura_max']);

    
    if (!empty($validatedData['pesoKg']))     $q->where('pesoKg', $validatedData['pesoKg']);
    if (!empty($validatedData['peso_min']))   $q->where('pesoKg', '>=', $validatedData['peso_min']);
    if (!empty($validatedData['peso_max']))   $q->where('pesoKg', '<=', $validatedData['peso_max']);

   
    if (!empty($validatedData['idade'])) {
        $maxDob = now()->subYears($validatedData['idade'])->endOfDay();
        $minDob = now()->subYears($validatedData['idade'] + 1)->addDay()->startOfDay();
        $q->whereBetween('dataNascimentoUsuario', [$minDob, $maxDob]);
    }

    
    if (!empty($validatedData['idade_min'])) {
        $dobMax = now()->subYears($validatedData['idade_min'])->endOfDay();   
        $q->where('dataNascimentoUsuario', '<=', $dobMax);
    }
    if (!empty($validatedData['idade_max'])) {
        $dobMin = now()->subYears($validatedData['idade_max'])->startOfDay(); 
        $q->where('dataNascimentoUsuario', '>=', $dobMin);
    }

    
    if (!empty($validatedData['estadoUsuario'])) $q->where('estadoUsuario', $validatedData['estadoUsuario']);
    if (!empty($validatedData['cidadeUsuario'])) $q->where('cidadeUsuario', $validatedData['cidadeUsuario']);
    if (!empty($validatedData['peDominante']))   $q->where('peDominante',   $validatedData['peDominante']);
    if (!empty($validatedData['maoDominante']))  $q->where('maoDominante',  $validatedData['maoDominante']);

   
    if ($sort !== 'todos') { 
        switch ($sort) {
            case 'altura':
                $q->orderBy('alturaCm', $direction);
                break;
            case 'peso':
                $q->orderBy('pesoKg', $direction);
                break;
            case 'idade':
                $q->orderBy('dataNascimentoUsuario', $direction);
                break;
            case 'nome':
                $q->orderBy('nomeCompletoUsuario', $direction);
                break;
            case 'recentes':
            default:
                $q->orderBy('updated_at', $direction);
                break;
        }
    }

    $result = $q->paginate($perPage)->appends($request->query());

    return response()->json($result, 200);


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
