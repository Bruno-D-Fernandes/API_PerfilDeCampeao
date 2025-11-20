<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clube;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthClubeController extends Controller
{
    
    public function login(Request $request)
    {
        $clube = Clube::where('cnpjClube', $request->cnpjClube)->first();

        if (! $clube || ! Hash::check($request->senhaClube, $clube->senhaClube)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        if($clube->status === Clube::STATUS_BLOQUEADO){
            return response()->json(['message' => 'Conta do clube foi bloqueado pelo seguinte motivo: '. $clube->bloque_reason], 403);
        }

        if($clube->status !== Clube::STATUS_ATIVO){
            return response()->json(['message' => 'Conta do clube não está ativa. Status atual: ' . $clube->status], 403);
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

    public function deleteAccount(Request $request)
{
    try {
        $clube = $request->user();

        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $fotoPerfilPath = $clube->getRawOriginal('fotoPerfilClube');
        if ($fotoPerfilPath) {
            Storage::disk('public')->delete($fotoPerfilPath);
            $clube->fotoPerfilClube = null;
        }

        $fotoBannerPath = $clube->getRawOriginal('fotoBannerClube');
        if ($fotoBannerPath) {
            Storage::disk('public')->delete($fotoBannerPath);
            $clube->fotoBannerClube = null;
        }

        $suffix = '#deleted#' . $clube->id . '#' . now()->timestamp;

        $clube->nomeClube  = $clube->nomeClube  . $suffix;
        $clube->cnpjClube  = $clube->cnpjClube  . $suffix;
        $clube->emailClube = $clube->emailClube . $suffix;

        if (defined(Clube::class . '::STATUS_DELETADO')) {
            $clube->status = Clube::STATUS_DELETADO;
        }

        $clube->reviewed_by      = null;
        $clube->reviewed_at      = null;
        $clube->rejection_reason = null;

        $clube->save();

        if (method_exists($clube, 'tokens')) {
            $clube->tokens()->delete();
        }

        return response()->json(['message' => 'Conta do clube excluída com sucesso'], 200);

    } catch (\Exception $e) {
        return response()->json([
            'error'   => 'Ocorreu um erro ao deletar a conta do clube',
            'message' => $e->getMessage(),
        ], 500);
    }
}
    public function updateAccount(Request $request)
    {
        $clube = $request->user();

        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nomeClube' => 'sometimes|required|string|max:255',
            'cidadeClube' => 'sometimes|required|string|max:255',
            'estadoClube' => 'sometimes|required|string|max:255',
            'anoCriacaoClube' => 'sometimes|required|date',
            'cnpjClube' => 'sometimes|required|string|max:20|unique:clubes,cnpjClube,' . $clube->id,
            'email'            => 'sometimes|required|email|max:255|unique:clubes,email,' . $clube->id,

            'current_password' => 'required_with:emailClube,senhaClube|string',


            'enderecoClube' => 'sometimes|required|string|max:255',
            'bioClube' => 'nullable|string',
            'senhaClube' => 'sometimes|required|string|min:6|confirmed',
        ]);

        if ($request->filled('emailClube')) {
            if (!Hash::check($request->input('current_password'), $clube->senhaClube)) {
                return response()->json(['message' => 'A senha atual está incorreta.'], 422);
            }
        $clube->emailClube = $request->input('emailClube');
    }

        if ($request->filled('senhaClube')) {
            if (!Hash::check($request->input('current_password'), $clube->senhaClube)) {
                return response()->json(['message' => 'A senha atual está incorreta.'], 422);
            }
        $clube->senhaClube = Hash::make($request->input('senhaClube'));
    }

        $data = $request->only([
        'nomeClube','cidadeClube','estadoClube','anoCriacaoClube',
        'cnpjClube','enderecoClube','bioClube','emailClube'
    ]);

    if ($request->filled('senhaClube')) {
        $data['senhaClube'] = Hash::make($request->input('senhaClube'));
    }

    // Salve de uma vez só
    $clube->fill($data)->save();

    return response()->json($clube->fresh(), 200);
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