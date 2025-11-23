<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Clube;
use App\Models\Usuario;

class EventoClubeController extends Controller
{
    public function listEventsClube(Request $request)
    {
        $clube = $request->user();
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $eventos = Evento::where('clube_id', $clube->id)->get();

        return response()->json(['eventos' => $eventos], 200);
    }
    public function eventInvites(Request $request, $eventoId){
        $clube = $request->user();
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }


        $evento = Evento::where('id', $eventoId)
            ->where('clube_id', $clube->id)
            ->first();

        if (! $evento) {
            return response()->json(['message' => 'Evento não encontrado para este clube.'], 404);
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
        ]);
    }

    public function deletarEvento(Request $request, $eventoId){
        $clube = $request->user();
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $evento = Evento::where('id', $eventoId)
            ->where('clube_id', $clube->id)
            ->first();

        if (! $evento) {
            return response()->json(['message' => 'Evento não encontrado para este clube.'], 404);
        }

        $evento->delete();

        return response()->json(['message' => 'Evento deletado com sucesso.'], 200);
    }

    public function detalhesEvento(Request $request, $eventoId){
        $clube = $request->user();
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $evento = Evento::where('id', $eventoId)
            ->where('clube_id', $clube->id)
            ->with('convites.usuario')
            ->first();

        if (! $evento) {
            return response()->json(['message' => 'Evento não encontrado para este clube.'], 404);
        }

        return response()->json(['evento' => $evento], 200);
    }

    public function criarEvento(Request $request){
        $clube = $request->user();
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_hora_inicio' => 'required|date',
            'data_hora_fim' => 'required|date|after_or_equal:data_hora_inicio',
            'cep'         => 'nullable|string|max:9',
            'estado'      => 'nullable|string|max:2',
            'cidade'      => 'nullable|string|max:100',
            'bairro'      => 'nullable|string|max:100',
            'rua'         => 'nullable|string|max:150',
            'numero'      => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:150',
            'localizacao' => 'nullable|string|max:255',
            'limite_participantes' => 'nullable|integer|min:1',
        ]);

        $evento = Evento::create([
            'clube_id' => $clube->id,
            'titulo' => $data['titulo'],
            'descricao' => $data['descricao'],
            'data_hora_inicio' => $data['data_hora_inicio'],
            'data_hora_fim' => $data['data_hora_fim'],
            'cep'         => $data['cep'],
            'estado'      => $data['estado'],
            'cidade'      => $data['cidade'],
            'bairro'      => $data['bairro'],
            'rua'         => $data['rua'],
            'numero'      => $data['numero'],
            'complemento' => $data['complemento'],
            'limite_participantes' => $data['limite_participantes'],
        ]);

        return response()->json(['evento' => $evento], 201);
    }

    public function atualizarEvento(Request $request, $eventoId){
        $clube = $request->user();
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $evento = Evento::where('id', $eventoId)
            ->where('clube_id', $clube->id)
            ->first();

        if (! $evento) {
            return response()->json(['message' => 'Evento não encontrado para este clube.'], 404);
        }

        $data = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descricao' => 'sometimes|nullable|string',
            'data_hora_inicio' => 'sometimes|required|date',
            'data_hora_fim' => 'sometimes|required|date|after_or_equal:data_hora_inicio',
            'cep'         => 'sometimes|nullable|string|max:9',
            'estado'      => 'sometimes|nullable|string|max:2',
            'cidade'      => 'sometimes|nullable|string|max:100',
            'bairro'      => 'sometimes|nullable|string|max:100',
            'rua'         => 'sometimes|nullable|string|max:150',
            'numero'      => 'sometimes|nullable|string|max:20',
            'complemento' => 'sometimes|nullable|string|max:150',
            'limite_participantes' => 'sometimes|nullable|integer|min:1',
        ]);

        $evento->update($data);

        return response()->json(['evento' => $evento], 200);
    }
}
