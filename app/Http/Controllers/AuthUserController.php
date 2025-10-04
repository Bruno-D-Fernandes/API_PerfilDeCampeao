<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthUserController extends Controller
{
    // Login do usuario
    public function login(Request $request)
    {
        try {
            $user = Usuario::where('emailUsuario', $request->emailUsuario)->first();

            if (!$user || !Hash::check($request->senhaUsuario, $user->senhaUsuario)) {
                return response()->json(['message' => 'Credenciais inválidas'], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
            'access_token' => "Bearer $token"
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro durante o login',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Perfil do usuario com token
    public function perfil(Request $request)
    {
        try {
            return response()->json($request->user()->load('seguidores')->load('seguindo'), 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao buscar o perfil',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logout realizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro durante o logout',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
