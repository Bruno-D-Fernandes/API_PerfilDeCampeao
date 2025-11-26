<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oportunidade;
use App\Models\Usuario;
use App\Models\Clube;
use App\Models\Posicao;
use App\Models\Inscricao;
use App\Models\Evento;
use Carbon\Carbon;

class DashClubeController extends Controller
{

    public function resumoGeral(Request $request)
    {
        try {
            $clube = $request->user();

            if (! $clube instanceof Clube) {
                return response()->json(['message' => 'Clube não autorizado'], 403);
            }

            $esporteId = $request->query('esporte_id');

            $inscricoesPendentesQuery = Inscricao::pending()
                ->whereHas('oportunidade', function ($q) use ($clube, $esporteId) {
                    $q->where('clube_id', $clube->id);

                    if ($esporteId) {
                        $q->where('esporte_id', $esporteId);
                    }
                });

            $inscricoesPendentes = $inscricoesPendentesQuery->count();

            $oportunidadesAtivasQuery = Oportunidade::approved()
                ->where('clube_id', $clube->id);

            if ($esporteId) {
                $oportunidadesAtivasQuery->where('esporte_id', $esporteId);
            }

            $oportunidadesAtivas = $oportunidadesAtivasQuery->count();

            $proximoEvento = Evento::query()
                ->where('clube_id', $clube->id)
                ->where('data_hora_inicio', '>=', Carbon::now())
                ->orderBy('data_hora_inicio', 'asc')
                ->first([
                    'id',
                    'titulo',
                    'descricao',
                    'data_hora_inicio',
                    'data_hora_fim',
                    'cidade',
                    'estado',
                    'bairro',
                    'rua',
                    'numero',
                ]);


            $usuariosUnicosEmListas = Usuario::query()
                ->whereHas('listas', function ($q) use ($clube) {
                    $q->where('listas.clube_id', $clube->id);
                })
                ->distinct('usuarios.id')
                ->count('usuarios.id');

            return response()->json([
                'inscricoes_pendentes'       => $inscricoesPendentes,
                'oportunidades_ativas'       => $oportunidadesAtivas,
                'proximo_evento'             => $proximoEvento,
                'usuarios_unicos_em_listas'  => $usuariosUnicosEmListas,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function distribuicaoPosicoes(Request $request)
    {
        try {
            $clube = $request->user();

            if (! $clube instanceof Clube) {
                return response()->json(['message' => 'Clube não autorizado'], 403);
            }

            $esporteId = $request->query('esporte_id');

            $query = Inscricao::query()
                ->join('oportunidades', 'inscricoes.oportunidade_id', '=', 'oportunidades.id')
                ->where('oportunidades.clube_id', $clube->id);

            if ($esporteId) {
                $query->where('oportunidades.esporte_id', $esporteId);
            }

            $rows = $query
                ->selectRaw('oportunidades.posicoes_id as posicao_id, COUNT(*) as total')
                ->groupBy('oportunidades.posicoes_id')
                ->get();

            $posicoes = Posicao::query()
                ->whereIn('id', $rows->pluck('posicao_id')->filter())
                ->get(['id', 'nomePosicao', 'idEsporte'])
                ->keyBy('id');

            $series = $rows->map(function ($row) use ($posicoes) {
                $posicao = $posicoes->get($row->posicao_id);

                return [
                    'posicao_id'   => $row->posicao_id,
                    'posicao_nome' => $posicao?->nomePosicao,
                    'esporte_id'   => $posicao?->idEsporte,
                    'total'        => (int) $row->total,
                ];
            });

            return response()->json([
                'data' => $series,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function inscricoesMensais(Request $request)
    {
        try {
            $clube = $request->user();

            if (! $clube instanceof Clube) {
                return response()->json(['message' => 'Clube não autorizado'], 403);
            }

            $esporteId = $request->query('esporte_id');
            $meses     = (int) $request->query('months', 6);

            $inicioJanela = Carbon::now()
                ->copy()
                ->subMonthsNoOverflow($meses - 1)
                ->startOfMonth();

            $dadosQuery = Inscricao::query()
                ->join('oportunidades', 'inscricoes.oportunidade_id', '=', 'oportunidades.id')
                ->where('oportunidades.clube_id', $clube->id)
                ->where('inscricoes.created_at', '>=', $inicioJanela);

            if ($esporteId) {
                $dadosQuery->where('oportunidades.esporte_id', $esporteId);
            }

            $dados = $dadosQuery
                ->selectRaw('YEAR(inscricoes.created_at) as ano, MONTH(inscricoes.created_at) as mes, COUNT(*) as total')
                ->groupBy('ano', 'mes')
                ->orderBy('ano')
                ->orderBy('mes')
                ->get();

            $series = $dados->map(function ($item) {
                $mes = str_pad($item->mes, 2, '0', STR_PAD_LEFT);

                return [
                    'ano'    => (int) $item->ano,
                    'mes'    => (int) $item->mes,
                    'rotulo' => $mes . '/' . $item->ano,
                    'total'  => (int) $item->total,
                ];
            });

            return response()->json([
                'data' => $series,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function topEstadosInscricoes(Request $request)
    {
        try {
            $clube = $request->user();

            if (! $clube instanceof Clube) {
                return response()->json(['message' => 'Clube não autorizado'], 403);
            }

            $esporteId = $request->query('esporte_id');

            $query = Inscricao::query()
                ->join('oportunidades', 'inscricoes.oportunidade_id', '=', 'oportunidades.id')
                ->join('usuarios', 'inscricoes.usuario_id', '=', 'usuarios.id')
                ->where('oportunidades.clube_id', $clube->id);

            if ($esporteId) {
                $query->where('oportunidades.esporte_id', $esporteId);
            }

            $dados = $query
                ->selectRaw('usuarios.estadoUsuario as estado, COUNT(*) as total')
                ->groupBy('estado')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            $series = $dados->map(function ($item) {
                return [
                    'estado' => $item->estado,
                    'total'  => (int) $item->total,
                ];
            });

            return response()->json([
                'data' => $series,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function atividadesRecentes(Request $request)
    {
        try {
            $clube = $request->user();

            if (! $clube instanceof Clube) {
                return response()->json(['message' => 'Clube não autorizado'], 403);
            }

            $esporteId = $request->query('esporte_id');
            $per_page  = (int) $request->query('per_page', 5);

            $ultimasOportunidadesQuery = Oportunidade::query()
                ->where('clube_id', $clube->id)
                ->with([
                    'esporte:id,nomeEsporte',
                    'posicao:id,nomePosicao',
                ]);

            if ($esporteId) {
                $ultimasOportunidadesQuery->where('esporte_id', $esporteId);
            }

            $ultimasOportunidades = $ultimasOportunidadesQuery
                ->orderByDesc('created_at')
                ->paginate($per_page, [
                    'id',
                    'tituloOportunidades',
                    'esporte_id',
                    'posicoes_id',
                    'clube_id',
                    'created_at',
                    'status',
                ]);

            $ultimasInscricoesQuery = Inscricao::query()
                ->with([
                    'usuario:id,nomeCompletoUsuario',
                    'oportunidade:id,tituloOportunidades,clube_id,esporte_id',
                ])
                ->whereHas('oportunidade', function ($q) use ($clube, $esporteId) {
                    $q->where('clube_id', $clube->id);

                    if ($esporteId) {
                        $q->where('esporte_id', $esporteId);
                    }
                });

            $ultimasInscricoes = $ultimasInscricoesQuery
                ->orderByDesc('created_at')
                ->paginate($per_page, [
                    'id',
                    'usuario_id',
                    'oportunidade_id',
                    'status',
                    'created_at',
                ]);

            return response()->json([
                'oportunidades' => $ultimasOportunidades,
                'inscricoes'    => $ultimasInscricoes,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
