<?php

namespace App\Http\Controllers;

use App\Events\EventoAtualizadoNotification;
use App\Events\MessageReceivedNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Clube;
use App\Models\Usuario;
use Carbon\Carbon;
use App\Models\ConviteEvento;

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

    public function deletarEvento(Request $request, $eventoId)
    {
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

    public function detalhesEvento(Request $request, $eventoId)
    {
        $clube = $request->user();
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $evento = Evento::where('id', $eventoId)
            ->where('clube_id', $clube->id)
            ->with([
                'convites' => function ($query) {
                    $query->ativos()       
                        ->with('usuario');
                },
            ])
            ->first();

        if (! $evento) {
            return response()->json(['message' => 'Evento não encontrado para este clube.'], 404);
        }

        return response()->json(['evento' => $evento], 200);
    }

    public function criarEvento(Request $request)
    {
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
            'limite_participantes' => 'nullable|integer|min:1',
            'color' => 'required|string|max:20'
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
            'color' => $data['color']
        ]);

        return response()->json(['evento' => $evento], 201);
    }

    public function atualizarEvento(Request $request, $eventoId)
    {
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
            'color' => 'required|string|max:20'
        ]);

        $evento->update($data);

        foreach ($evento->convites as $convite) {
            $convite->usuario->notify(new EventoAtualizadoNotification($evento));
        }

        return response()->json(['evento' => $evento], 200);
    }

    public function calendar(Request $request)
    {
        $clube = $request->user();

        if (! $clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $monthParam = $request->query('month');

        if ($monthParam) {
            try {
                [$year, $month] = explode('-', $monthParam);
                $start = Carbon::createFromDate((int) $year, (int) $month, 1)->startOfDay();
            } catch (\Throwable $e) {
                return response()->json([
                    'message' => 'Parâmetro "month" inválido. Use o formato YYYY-MM, por exemplo: 2025-11.'
                ], 422);
            }
        } else {
            $start = now()->startOfMonth()->startOfDay();
        }

        $end = (clone $start)->endOfMonth()->endOfDay();

        $search = $request->query('search');

        $query = Evento::where('clube_id', $clube->id)
            ->whereBetween('data_hora_inicio', [$start, $end])
            ->with('convites.usuario');

        if ($search) {
            $query->where('titulo', 'LIKE', '%' . $search . '%');
        }

        $eventos = $query->get();

        $calendar = [];

        foreach ($eventos as $evento) {
            if (! $evento->data_hora_inicio) {
                continue;
            }

            $dateKey = $evento->data_hora_inicio->toDateString();

            $convites = $evento->convites;

            $calendar[$dateKey][] = [
                'evento_id'        => $evento->id,
                'titulo'           => $evento->titulo,
                'descricao'        => $evento->descricao,
                'data_hora_inicio' => $evento->data_hora_inicio,
                'data_hora_fim'    => $evento->data_hora_fim,

                'cep'         => $evento->cep,
                'cidade'      => $evento->cidade,
                'estado'      => $evento->estado,
                'bairro'      => $evento->bairro,
                'rua'         => $evento->rua,
                'numero'      => $evento->numero,
                'complemento' => $evento->complemento,

                'limite_participantes' => $evento->limite_participantes,

                'total_convites'   => $convites->count(),
                'total_aceitos'    => $convites->where('status', ConviteEvento::STATUS_ACEITO)->count(),
                'total_pendentes'  => $convites->where('status', ConviteEvento::STATUS_PENDENTE)->count(),
                'total_expirados'  => $convites->where('status', ConviteEvento::STATUS_EXPIRADO)->count(),
                'total_cancelados' => $convites->where('status', ConviteEvento::STATUS_CANCELADO_PELO_CLUBE)->count(),

                'vagas_disponiveis' => $evento->limite_participantes
                    ? max($evento->limite_participantes - $convites->where('status', ConviteEvento::STATUS_ACEITO)->count(), 0)
                    : null,

                'color' => $evento->color,
            ];
        }

        $responseData = [
            'month'    => $start->format('Y-m'),
            'calendar' => $calendar,
        ];

        if ($request->wantsJson()) {
            return response()->json($responseData, 200);
        }

        if ($request->ajax()) {
            $htmlGrid = view('clube.partials.calendar-grid', ['data' => $responseData, 'selectedDateStr' => $request->query('date')])->render();
    
            return response()->json([
                'html' => $htmlGrid,
                'calendarData' => $calendar,
                'month' => $start->format('Y-m'),
                'year' => $start->year
            ]);
        }

        return view('clube.agenda', ['data' => $responseData]);
    }

    public function atualizarCorEvento(Request $request, $id)
    {
        $clube = $request->user();

        if (! $clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $data = $request->validate([
            'color' => 'nullable|string|max:20',
        ]);

        $evento = Evento::where('id', $id)
            ->where('clube_id', $clube->id)
            ->first();

        if (! $evento) {
            return response()->json(['message' => 'Evento não encontrado para este clube.'], 404);
        }

        $evento->color = $data['color'] ?? null;
        $evento->save();

        return response()->json([
            'message' => 'Cor do evento atualizada com sucesso.',
            'evento'  => $evento,
        ], 200);
    }

    public function proximosEventos(Request $request)
    {
        $clube = $request->user();

        if (! $clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $request->validate([
            'data_referencia' => 'nullable|date',
            'limit'           => 'nullable|integer|min:1|max:50',
        ]);

        $dataReferencia = $request->input('data_referencia') 
            ? Carbon::parse($request->input('data_referencia')) 
            : Carbon::now();

        $limit = (int) $request->input('limit', 1);

        $eventos = Evento::where('clube_id', $clube->id)
            ->where('data_hora_inicio', '>=', $dataReferencia)
            ->orderBy('data_hora_inicio', 'asc')
            ->limit($limit)
            ->withCount('convites')
            ->get();

        return response()->json([
            'data_referencia' => $dataReferencia->toDateTimeString(),
            'eventos'         => $eventos
        ], 200);
    }

    public function dayDetails(Request $request)
    {
        $clube = $request->user();
        
        $dateStr = $request->query('date');

        if (!$dateStr) return '';

        $date = Carbon::parse($dateStr);

        $eventos = Evento::where('clube_id', $clube->id)
            ->whereDate('data_hora_inicio', $date)
            ->orderBy('data_hora_inicio', 'asc')
            ->get();

        return view('clube.partials.sidebar-events-list', ['eventos' => $eventos, 'emptyMessage' => 'Nenhum evento neste dia.']);
    }

    public function nextEventsHtml(Request $request)
    {
        $clube = $request->user();

        $eventos = Evento::where('clube_id', $clube->id)
            ->where('data_hora_inicio', '>', now())
            ->orderBy('data_hora_inicio', 'asc')
            ->limit(3)
            ->get();

        return view('clube.partials.sidebar-events-list', ['eventos' => $eventos, 'emptyMessage' => 'Sem próximos eventos agendados.']);
    }
    
    public function listUserEvents(Request $request)
    {
        $user = $request->user();

        if (!$user instanceof Usuario) {
            return response()->json(['message' => 'Acesso negado. Apenas usuários podem listar seus eventos.'], 403);
        }

        $eventos = Evento::whereHas('convites', function ($query) use ($user) {
            $query->where('usuario_id', $user->id)
                ->where('status', 'aceito');
        })->get();

        return response()->json(['eventos' => $eventos], 200);
    }
}
