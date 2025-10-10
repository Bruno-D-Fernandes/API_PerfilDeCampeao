<?php

namespace App\Http\Controllers;

use App\Events\UserFollowedEvent;
use App\Events\ClubFollowedEvent;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthUserController;
use App\Models\Clube;

class UserController extends Controller
{
    // Listar todos os usuários
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    // Criar novo usuário
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nomeCompletoUsuario' => 'required|string|max:255',
                'emailUsuario' => 'required|email|unique:usuarios,emailUsuario',
                'senhaUsuario' => 'required|string|min:3',
                'dataNascimentoUsuario' => 'required|date',
                'generoUsuario' => 'nullable|string|max:100',
                'estadoUsuario' => 'nullable|string|max:100',
                'cidadeUsuario' => 'nullable|string|max:100',
                'alturaCm' => 'nullable|numeric|min:50|max:300',
                'pesoKg' => 'nullable|numeric|min:20|max:500',
                'peDominante' => 'nullable|in:direito,esquerdo',
                'maoDominante' => 'nullable|in:destro,canhoto',
            ]);

            // Cria o usuário
            $user = Usuario::create([
                'nomeCompletoUsuario' => $validatedData['nomeCompletoUsuario'],
                'emailUsuario' => $validatedData['emailUsuario'],
                'senhaUsuario' => Hash::make($validatedData['senhaUsuario']),
                'dataNascimentoUsuario' => $validatedData['dataNascimentoUsuario'],
                'generoUsuario' => $validatedData['generoUsuario'] ?? null,
                'estadoUsuario' => $validatedData['estadoUsuario'] ?? null,
                'cidadeUsuario' => $validatedData['cidadeUsuario'] ?? null,
                'alturaCm' => $validatedData['alturaCm'] ?? null,
                'pesoKg' => $validatedData['pesoKg'] ?? null,
                'peDominante' => $validatedData['peDominante'] ?? null,
                'maoDominante' => $validatedData['maoDominante'] ?? null,
            ]);

            $authController = new AuthUserController();
            return $authController->login($request);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Mostrar usuário específico
    public function show(string $id)
    {
        try {
            $usuario = Usuario::find($id);
            if (!$usuario) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            return response()->json($usuario, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao buscar o usuário',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Atualizar um usuário
    public function update(Request $request, string $id)
    {
        try {
            $usuario = Usuario::find($id);
            if (!$usuario) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $usuario->update($request->all());

            return response()->json($usuario, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao atualizar o usuário',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Deletar um usuário
    public function destroy(string $id)
    {
        try {
            $usuario = Usuario::find($id);
            if (!$usuario) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $usuario->delete();

            return response()->json(['message' => 'Usuário deletado com sucesso'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao deletar o usuário',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
