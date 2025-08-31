<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbusuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'nomeCompletoUsuario' => 'required|string|max:255',
        'nomeUsuario' => 'nullable|string|max:50|unique:tbusuario,nomeUsuario',
        'emailUsuario' => 'required|email|unique:tbusuario,emailUsuario',
        'senhaUsuario' => 'required|string|min:3',
        'nacionalidadeUsuario' => 'nullable|string|max:100',
        'dataNascimentoUsuario' => 'required|date',
        'fotoPerfilUsuario' => 'nullable|string|max:300',
        'fotoBannerUsuario' => 'nullable|string|max:400',
        'bioUsuario' => 'nullable|string|max:500',
        'alturaCmUsuario' => 'nullable|numeric|min:50|max:300',
        'pesoKgUsuario' => 'nullable|numeric|min:20|max:500',
        'peDominanteUsuario' => 'nullable|in:direito,esquerdo',
        'maoDominanteUsuario' => 'nullable|in:direita,esquerda',
        'generoUsuario' => 'nullable|string|max:100',
        'esporte' => 'nullable|string|max:100',
        'posicao' => 'nullable|string|max:100',
        'estadoUsuario' => 'nullable|string|max:100',
        'cidadeUsuario' => 'nullable|string|max:100',
        'categoria' => 'nullable|string|max:100',
        'temporadasUsuario' => 'nullable|string|max:100',
        'confirmacaoSenhaUsuario' => 'nullable|string|min:3|same:senhaUsuario'
    ]);

    $user = tbusuario::create([
        'nomeCompletoUsuario' => $validatedData['nomeCompletoUsuario'],
        'nomeUsuario' => $validatedData['nomeUsuario'],
        'emailUsuario' => $validatedData['emailUsuario'],
        'senhaUsuario' => Hash::make($validatedData['senhaUsuario']),
        'nacionalidadeUsuario' => $validatedData['nacionalidadeUsuario'] ?? null,
        'dataNascimentoUsuario' => $validatedData['dataNascimentoUsuario'],
        'fotoPerfilUsuario' => $validatedData['fotoPerfilUsuario'] ?? null,
        'fotoBannerUsuario' => $validatedData['fotoBannerUsuario'] ?? null,
        'bioUsuario' => $validatedData['bioUsuario'] ?? null,
        'alturaCm' => $validatedData['alturaCmUsuario'] ?? null,
        'pesoKg' => $validatedData['pesoKgUsuario'] ?? null,
        'peDominante' => $validatedData['peDominanteUsuario'] ?? null,
        'maoDominante' => $validatedData['maoDominanteUsuario'] ?? null,
        'generoUsuario' => $validatedData['generoUsuario'] ?? null,
        'esporte' => $validatedData['esporte'] ?? null,
        'posicao' => $validatedData['posicao'] ?? null,
        'estadoUsuario' => $validatedData['estadoUsuario'] ?? null,
        'cidadeUsuario' => $validatedData['cidadeUsuario'] ?? null,
        'categoria' => $validatedData['categoria'] ?? null,
        'temporadasUsuario' => $validatedData['temporadasUsuario'] ?? null
    ]);

    $authController = new AuthController();
    
    return $authController->login($request);
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
