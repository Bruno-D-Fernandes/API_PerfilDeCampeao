<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthUserController;

class UserController extends Controller
{
    public function pesquisa(Request $request)
    {
        $search = $request->pesquisa;
        $forma = $request->ordenarpor;

        if (is_null($search)) {
            $query = Usuario::query();

            if ($forma !== 'todos' && !is_null($forma)) {
                $query->orderBy($forma);
            }

            return response()->json($query->get());
        }

        $query = Usuario::where(function ($query) use ($search) {
            $query->where('nomeCompletoUsuario', 'like', "%{$search}%")
                ->orWhere('nomeUsuario', 'like', "%{$search}%");
        });

        if ($forma !== 'todos') {
            $query->orderBy($forma);
        }

        return response()->json($query->get());
    }

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
                'nomeUsuario' => 'nullable|string|max:50|unique:usuarios,nomeUsuario',
                'emailUsuario' => 'required|email|unique:usuarios,emailUsuario',
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
                'estadoUsuario' => 'nullable|string|max:100',
                'cidadeUsuario' => 'nullable|string|max:100',
                'temporadasUsuario' => 'nullable|string|max:100',

                // Arrays de IDs para relacionamentos N:N
                'posicoes' => 'nullable|array',
                'posicoes.*' => 'integer|exists:posicoes,id',

                'esportes' => 'nullable|array',
                'esportes.*' => 'integer|exists:esportes,id',

                'categorias' => 'nullable|array',
                'categorias.*' => 'integer|exists:categorias,id',
            ]);

            // Cria o usuário
            $user = Usuario::create([
                'nomeCompletoUsuario' => $validatedData['nomeCompletoUsuario'],
                'nomeUsuario' => $validatedData['nomeUsuario'] ?? null,
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
                'estadoUsuario' => $validatedData['estadoUsuario'] ?? null,
                'cidadeUsuario' => $validatedData['cidadeUsuario'] ?? null,
                'temporadasUsuario' => $validatedData['temporadasUsuario'] ?? null,
                'dataCadastroUsuario' => now(),
            ]);

            // Relacionamentos N:N 
            if (!empty($validatedData['posicoes'])) {
                $user->posicoes()->sync($validatedData['posicoes']);
            }

            if (!empty($validatedData['esportes'])) {
                $user->esportes()->sync($validatedData['esportes']);
            }

            if (!empty($validatedData['categorias'])) {
                $user->categorias()->sync($validatedData['categorias']);
            }

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
