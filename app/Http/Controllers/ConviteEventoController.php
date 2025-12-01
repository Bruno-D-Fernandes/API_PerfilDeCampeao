<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConviteEvento;
use App\Models\Usuario;
use App\Models\Evento;
use App\Models\Clube;
use Carbon\Carbon;

class ConviteEventoController extends Controller
{
    protected function baseQueryForUser(Request $request)
    {
        $user = $request->user();

        if (!$user instanceof Usuario) {
            abort(response()->json(['message' => 'Usuário não encontrado.'], 404));
        }

        return ConviteEvento::doUsuario($user->id)
            ->with('evento');
    }

    public function pendentes(Request $request)
    {
        $convites = $this->baseQueryForUser($request)
            ->pendentes()
            ->orderByDesc('sent_at')
            ->get();

        return response()->json([
            'convites' => $convites,
        ]);
    }

    public function aceitos(Request $request)
    {
        $convites = $this->baseQueryForUser($request)
            ->ativos() 
            ->orderByDesc('sent_at')
            ->get();

        return response()->json([
            'convites' => $convites,
        ]);
    }

    public function expirados(Request $request)
    {
        $convites = $this->baseQueryForUser($request)
            ->expirados()
            ->orderByDesc('sent_at')
            ->get();

        return response()->json([
            'convites' => $convites,
        ]);
    }

    public function canceladosPeloClube(Request $request)
    {
        $convites = $this->baseQueryForUser($request)
            ->canceladosPeloClube()
            ->orderByDesc('sent_at')
            ->get();

        return response()->json([
            'convites' => $convites,
        ]);
    }

    public function calendar(Request $request)
    {
        $user = $request->user();

        if (!$user instanceof Usuario) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        $monthParam = $request->query('month');

        if ($monthParam) {
            try {
                [$year, $month] = explode('-', $monthParam);
                $start = Carbon::createFromDate((int) $year, (int) $month, 1)->startOfDay();
            } catch (\Throwable $e) {
                return response()->json([
                    'message' => 'Parâmetro "month" inválido. Use o formato YYYY-MM, por exemplo: 2025-11.',
                ], 422);
            }
        } else {
            $start = now()->startOfMonth()->startOfDay();
        }

        $end = (clone $start)->endOfMonth()->endOfDay();


        $convites = $this->baseQueryForUser($request)
            ->ativos()
            ->whereHas('evento', function ($query) use ($start, $end) {
                $query->whereBetween('data_hora_inicio', [$start, $end]);
            })
            ->get();

      
        $calendar = [];

        foreach ($convites as $convite) {
            if (!$convite->evento || !$convite->evento->data_hora_inicio) {
                continue;
            }

            $dateKey = $convite->evento->data_hora_inicio->toDateString();

            $calendar[$dateKey][] = [
                'convite_id'   => $convite->id,
                'evento_id'    => $convite->evento->id,
                'titulo'       => $convite->evento->titulo,
                'descricao'    => $convite->evento->descricao,
                'data_hora_inicio' => $convite->evento->data_hora_inicio,
                'data_hora_fim'    => $convite->evento->data_hora_fim,
                'cep'         => $convite->evento->cep,
                'cidade'     => $convite->evento->cidade,
                'estado'     => $convite->evento->estado,
                'bairro'     => $convite->evento->bairro,
                'rua'        => $convite->evento->rua,
                'numero'     => $convite->evento->numero,
                'complemento'=> $convite->evento->complemento,
                'color'       => $convite->color,
            ];
        }

        return response()->json([
            'month'    => $start->format('Y-m'),
            'calendar' => $calendar,
        ]);
    }

    public function updateColor(Request $request, $conviteId)
{
    $user = $request->user();

    if (! $user instanceof Usuario) {
        return response()->json(['message' => 'Usuário não encontrado.'], 404);
    }

    $data = $request->validate([
        'color' => 'nullable|string|max:20',
    ]);

    $convite = ConviteEvento::where('id', $conviteId)
        ->where('usuario_id', $user->id)
        ->first();

    if (! $convite) {
        return response()->json(['message' => 'Convite não encontrado para este usuário.'], 404);
    }

    $convite->color = $data['color'] ?? null;
    $convite->save();

    return response()->json([
        'message' => 'Cor atualizada com sucesso.',
        'convite' => $convite,
    ], 200);
}
}