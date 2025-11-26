<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evento;

class AdminEventoController extends Controller
{
    public function listAllEvents(Request $request)
    {
        $eventos = Evento::with('clube')->get();

        return response()->json([
            'eventos' => $eventos,
        ], 200);
    }

    public function eventInvitesAdmin(Request $request, $eventoId)
    {
        $evento = Evento::with('clube')->find($eventoId);

        if (! $evento) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        $pendentes = $evento->convites()
            ->pendentes()
            ->with('usuario')
            ->get();

        $aceitos = $evento->convites()
            ->ativos()
            ->with('usuario')
            ->get();

        $expirados = $evento->convites()
            ->expirados()
            ->with('usuario')
            ->get();

        $cancelados = $evento->convites()
            ->canceladosPeloClube()
            ->with('usuario')
            ->get();

        return response()->json([
            'evento'   => $evento,
            'convites' => [
                'pendentes'             => $pendentes,
                'aceitos'               => $aceitos,
                'expirados'             => $expirados,
                'cancelados_pelo_clube' => $cancelados,
            ],
        ], 200);
    }

    public function showEvent(Request $request, $eventoId)
    {
        $evento = Evento::with(['clube', 'convites.usuario'])->find($eventoId);

        if (! $evento) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        return response()->json([
            'evento' => $evento,
        ], 200);
    }

    public function updateEvent(Request $request, $eventoId)
    {
        $evento = Evento::find($eventoId);

        if (! $evento) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        $data = $request->validate([
            'titulo'           => 'sometimes|required|string|max:255',
            'descricao'        => 'sometimes|nullable|string',
            'data_hora_inicio' => 'sometimes|required|date',
            'data_hora_fim'    => 'sometimes|required|date|after_or_equal:data_hora_inicio',

            'cep'         => 'sometimes|nullable|string|max:9',
            'estado'      => 'sometimes|nullable|string|max:2',
            'cidade'      => 'sometimes|nullable|string|max:100',
            'bairro'      => 'sometimes|nullable|string|max:100',
            'rua'         => 'sometimes|nullable|string|max:150',
            'numero'      => 'sometimes|nullable|string|max:20',
            'complemento' => 'sometimes|nullable|string|max:150',
            'localizacao' => 'sometimes|nullable|string|max:255',

            'limite_participantes' => 'sometimes|nullable|integer|min:1',
        ]);

        $evento->update($data);

        return response()->json([
            'message' => 'Evento atualizado com sucesso.',
            'evento'  => $evento,
        ], 200);
    }

    public function deleteEvent(Request $request, $eventoId)
    {
        $evento = Evento::find($eventoId);

        if (! $evento) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        $evento->delete();

        return response()->json([
            'message' => 'Evento deletado com sucesso.',
        ], 200);
    }
}
