<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Clube;
use App\Events\UserFollowedEvent;
use App\Events\ClubFollowedEvent;

class SeguidorController extends Controller 
{
    public function getSeguidores(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $usuario = auth()->user();

        $seguidoresPaginados = $usuario->seguidores()->paginate($perPage);

        return response()->json($seguidoresPaginados, 200);
    }

    public function getSeguindo(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $usuario = auth()->user();

        $seguindoPaginado = $usuario->seguindoQuery()->inRandomOrder()->paginate($perPage);

        return response()->json($seguindoPaginado, 200);
    }

    public function getAmigos(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $usuario = auth()->user();

        $amigosPaginados = $usuario->amigos()->paginate($perPage);

        return response()->json($amigosPaginados, 200);
    }

    public function getSugestoes(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $usuario = auth()->user();

        $sugestoesPaginadas = $usuario->sugestoesQuery()->inRandomOrder()->paginate($perPage);

        return response()->json($sugestoesPaginadas, 200);
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

            $jaSegue = $seguidor->seguindoUsuarios()->where('seguivel_id', $usuarioSeguido->id)->exists();
        
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

            $jaSegue = $seguidor->seguindoClubes()->where('seguivel_id', $clubeSeguido->id)->exists();
        
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

            if ($seguidor->id == $usuarioDeixado->id) {
                return response()->json(['message' => 'Você tem certeza?'], 422);
            }

            $jaSegue = $seguidor->seguindoUsuarios()->where('seguivel_id', $usuarioDeixado->id)->exists();
        
            if (!$jaSegue) {
                return response()->json(['message' => 'Você não segue esse usuário'], 409);
            }

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

            $jaSegue = $seguidor->seguindoClubes()->where('seguivel_id', $clubeDeixado->id)->exists();

            if (!$jaSegue) {
                return response()->json(['message' => 'Você não segue esse clube'], 409);
            }

            $seguidor->seguindoClubes()->detach($clubeDeixado->id);

            return response()->json(['message' => 'Você deixou de seguir o clube com sucesso'], 200);

        } catch(\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao tentar deixar de seguir o clube',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}