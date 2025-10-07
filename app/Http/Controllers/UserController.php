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

    public function getSeguindoUsuarios(string $id)
    {
        try {
            $usuario = Usuario::find($id);

            if (!$usuario) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $seguindo = $usuario->seguindoUsuarios()->paginate(15); 

            return response()->json($seguindo, 200);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar quem o usuário segue.'], 500);
        }
    }

    public function getSeguindoClubes(string $id)
    {
        try {
            $usuario = Usuario::find($id);

            if (!$usuario) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $seguindo = $usuario->seguindoClubes()->paginate(15);

            return response()->json($seguindo, 200);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar os clubes que o usuário segue.'], 500);
        }
    }

    public function seguirUsuario(string $id)
    {
        try {
            $usuarioSeguido = Usuario::find($id);

            if (!$usuarioSeguido) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $seguidor = auth()->user();

            if ($seguidor->id == $usuarioSeguido->id) {
                return response()->json(['message' => 'Você não pode seguir a si mesmo'], 422);
            }

            $jaSegue = $seguidor->seguindoUsuarios()->where('usuario_seguido_id', $usuarioSeguido->id)->exists();
        
            if ($jaSegue) {
                return response()->json(['message' => 'Você já está seguindo este usuário'], 409);
            }

            $seguidor->seguindoUsuarios()->attach($usuarioSeguido->id);

            event(new UserFollowedEvent($seguidor, $usuarioSeguido));

            return response()->json(['message' => 'Usuário seguido com sucesso'], 200);

        } catch(\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao tentar seguir o usuário',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function seguirClube(string $id)
    {
        try {
            $clubeSeguido = Clube::find($id);

            if (!$clubeSeguido) {
                return response()->json(['message' => 'Clube não encontrado'], 404);
            }

            $seguidor = auth()->user();

            $jaSegue = $seguidor->seguindoClubes()->where('clube_id', $clubeSeguido->id)->exists();
        
            if ($jaSegue) {
                return response()->json(['message' => 'Você já está seguindo este clube'], 409);
            }

            $seguidor->seguindoClubes()->attach($clubeSeguido->id);

            event(new ClubFollowedEvent($seguidor, $clubeSeguido));

            return response()->json(['message' => 'Clube seguido com sucesso'], 200);

        } catch(\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao tentar seguir o usuário',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deixarDeSeguirUsuario(string $id)
    {
        try {
            $usuarioDeixado = Usuario::find($id);

            if (!$usuarioDeixado) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $seguidor = auth()->user();

            $seguidor->seguindoUsuarios()->detach($usuarioDeixado->id);

            return response()->json(['message' => 'Você deixou de seguir o usuário com sucesso'], 200);

        } catch(\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao tentar deixar de seguir o usuário',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deixarDeSeguirClube(string $id)
    {
        try {
            $clubeDeixado = Clube::find($id);

            if (!$clubeDeixado) {
                return response()->json(['message' => 'Clube não encontrado'], 404);
            }

            $seguidor = auth()->user();

            $seguidor->seguindoClubes()->detach($clubeDeixado->id);

            return response()->json(['message' => 'Você deixou de seguir o clube com sucesso'], 200);

        } catch(\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao tentar deixar de seguir o clube',
                'message' => $e->getMessage()
            ], 500);
        }
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
