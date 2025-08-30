<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbusuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        'nomeUsuario' => 'required|string|max:50|unique:tbusuario,nomeUsuario',
        'emailUsuario' => 'required|email|unique:tbusuario,emailUsuario',
        'senhaUsuario' => 'required|string|min:6',
        'nacionalidadeUsuario' => 'nullable|string|max:100',
        'dataNascimentoUsuario' => 'required|date',
        'fotoPerfilUsuario' => 'nullable|string|max:300',
        'fotoBannerUsuario' => 'nullable|string|max:400',
        'bioUsuario' => 'nullable|string|max:500',
        'alturaCmUsuario' => 'nullable|numeric|min:50|max:300',
        'pesoKgUsuario' => 'nullable|numeric|min:20|max:500',
        'peDominanteUsuario' => 'nullable|in:direito,esquerdo',
        'maoDominanteUsuario' => 'nullable|in:direita,esquerda'
    ]);

    $user = tbusuario::create([
        'nomeCompletoUsuario' => $validatedData['nomeCompletoUsuario'],
        'nomeUsuario' => $validatedData['nomeUsuario'],
        'emailUsuario' => $validatedData['emailUsuario'],
        'senhaUsuario' => Hash::make($validatedData['senhaUsuario']),
        'nacionalidadeUsuario' => $validatedData['nacionalidadeUsuario'] ?? null,
        'dataNascimentoUsuario' => $validatedData['dataNascimentoUsuario'],
        'dataCadastroUsuario' => now(),
        'fotoPerfilUsuario' => $validatedData['fotoPerfilUsuario'] ?? null,
        'fotoBannerUsuario' => $validatedData['fotoBannerUsuario'] ?? null,
        'bioUsuario' => $validatedData['bioUsuario'] ?? null,
        'alturaCmUsuario' => $validatedData['alturaCmUsuario'] ?? null,
        'pesoKgUsuario' => $validatedData['pesoKgUsuario'] ?? null,
        'peDominanteUsuario' => $validatedData['peDominanteUsuario'] ?? null,
        'maoDominanteUsuario' => $validatedData['maoDominanteUsuario'] ?? null
    ]);

    return response()->json($user, 201);
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
