<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthUserController extends Controller
{
    
    public function login(Request $request)
    {
        $user = Usuario::where('emailUsuario', $request->emailUsuario)->first();

        if (! $user || ! Hash::check($request->senhaUsuario, $user->senhaUsuario)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

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
    
    
}