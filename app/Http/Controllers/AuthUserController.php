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
            return response()->json($request->user(), 200);
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

    public function deleteAccount(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user instanceof Usuario) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }
            $user->delete();
            return response()->json(['message' => 'Conta do usuário excluida com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao deletar a conta',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateAccount(Request $request)
    {
        try {
           $user = $request->user();

            if (!$user instanceof Usuario) {
                return response()->json(['message' => 'Não autenticado'], 401);
            }

            $validatedData = $request->validate([
                'nomeCompletoUsuario'   => 'sometimes|required|string|max:255',
                'emailUsuario'          => 'sometimes|required|email|unique:usuarios,emailUsuario,' . $user->id,
                'senhaUsuario'          => 'sometimes|required|string|min:3|confirmed',
                'dataNascimentoUsuario' => 'sometimes|required|date',
                'generoUsuario'         => 'sometimes|nullable|string|max:100',
                'estadoUsuario'         => 'sometimes|nullable|string|max:100',
                'cidadeUsuario'         => 'sometimes|nullable|string|max:100',
                'alturaCm'              => 'sometimes|nullable|numeric|min:50|max:300',
                'pesoKg'                => 'sometimes|nullable|numeric|min:20|max:500',
                'peDominante'           => 'sometimes|nullable|in:direito,esquerdo',
                'maoDominante'          => 'sometimes|nullable|in:destro,canhoto',
                'categoria_id'          => 'sometimes|nullable|exists:categorias,id',
            ]);

            if (!empty($validatedData['senhaUsuario'])) {
                $validatedData['senhaUsuario'] = Hash::make($validatedData['senhaUsuario']);
            }

            $user->update($validatedData);

            $user->makeHidden(['senhaUsuario']);

            return response()->json([
                'message' => 'Conta atualizada com sucesso',
                'user'    => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao atualizar a conta',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
