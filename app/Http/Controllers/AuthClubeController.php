<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clube;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthClubeController extends Controller
{
    
    public function loginClube(Request $request)
    {
        $clube = Clube::where('cnpjClube', $request->cnpjClube)->first();

        if (! $clube || ! Hash::check($request->senhaClube, $clube->senhaClube)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $token = $clube->createToken('auth_token', ['club'], null, 'club_sanctum')->plainTextToken;

        return response()->json([
           'access_token' => "Bearer $token"
        ]);
    }

    public function perfil(Request $request)
    {
        return response()->json($request->user(), 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
    
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
