<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oportunidade;
use App\Models\Clube;
use App\Models\Posicao;
use App\Models\Inscricao;
use App\Models\Evento;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashClubeController extends Controller
{
    public function dashboardData(Request $request)
    {
        try {
            $clube = Auth::guard('club')->user();

            if (! $clube instanceof Clube) {
                if ($request->wantsJson()) {
                    return response()->json(['message' => 'Clube não autorizado'], 403);
                }
                abort(403, 'Acesso não autorizado.');
            }

            $esporteId = $request->query('esporte_id', $clube->esporte->id);
            $meses = (int) $request->query('months', 6);
            $perPage = (int) $request->query('per_page', 5);

            $resumo = $this->getResumoGeral($clube, $esporteId);
            $distribuicaoPosicoes = $this->getDistribuicaoPosicoes($clube, $esporteId);
            $inscricoesMensais = $this->getInscricoesMensais($clube, $esporteId, $meses);
            $topEstados = $this->getTopEstados($clube, $esporteId);
            $atividadesRecentes = $this->getAtividadesRecentes($clube, $esporteId, $perPage);
            
            $proximosEventos = $this->getProximosEventos($clube, 1);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'resumo' => $resumo,
                    'graficos' => [
                        'distribuicao_posicoes' => $distribuicaoPosicoes,
                        'inscricoes_mensais' => $inscricoesMensais,
                        'top_estados' => $topEstados
                    ],
                    'atividades_recentes' => $atividadesRecentes,
                    'proximos_eventos' => $proximosEventos
                ], 200);
            }

            return view('clube.dashboard', [
                'resumo' => $resumo,
                'distribuicaoPosicoes' => $distribuicaoPosicoes,
                'inscricoesMensais' => $inscricoesMensais,
                'topEstados' => $topEstados,
                'atividadesRecentes' => $atividadesRecentes,
                'proximosEventos' => $proximosEventos
            ]);

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => 'Erro ao carregar dashboard: ' . $e->getMessage(),
                    'trace' => config('app.debug') ? $e->getTrace() : null
                ], 500);
            }

            throw $e; 
        }
    }

   private function getResumoGeral($clube, $esporteId)
{
    $agora            = Carbon::now();
    $inicioMesAtual   = $agora->copy()->startOfMonth();
    $fimMesAtual      = $agora->copy()->endOfMonth();

    $inicioMesAnterior = $inicioMesAtual->copy()->subMonth();
    $fimMesAnterior    = $inicioMesAtual->copy()->subDay();


    $inscricoesPendentesMesAtual = Inscricao::pending()
        ->whereBetween('created_at', [$inicioMesAtual, $fimMesAtual])
        ->whereHas('oportunidade', function ($q) use ($clube, $esporteId) {
            $q->where('clube_id', $clube->id);
            if ($esporteId) {
                $q->where('esporte_id', $esporteId);
            }
        })
        ->count();

    $inscricoesPendentesMesAnterior = Inscricao::pending()
        ->whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])
        ->whereHas('oportunidade', function ($q) use ($clube, $esporteId) {
            $q->where('clube_id', $clube->id);
            if ($esporteId) {
                $q->where('esporte_id', $esporteId);
            }
        })
        ->count();

    $diffInscricoes = $inscricoesPendentesMesAtual - $inscricoesPendentesMesAnterior;
    $percentInscricoes = $inscricoesPendentesMesAnterior > 0
        ? round(($diffInscricoes / $inscricoesPendentesMesAnterior) * 100, 2)
        : null;

    $oportunidadesAtivasTotal = Oportunidade::approved()
        ->where('clube_id', $clube->id)
        ->when($esporteId, fn ($q) => $q->where('esporte_id', $esporteId))
        ->count();

    $oportunidadesAtivasMesAtual = Oportunidade::approved()
        ->where('clube_id', $clube->id)
        ->when($esporteId, fn ($q) => $q->where('esporte_id', $esporteId))
        ->whereBetween('created_at', [$inicioMesAtual, $fimMesAtual])
        ->count();

    $oportunidadesAtivasMesAnterior = Oportunidade::approved()
        ->where('clube_id', $clube->id)
        ->when($esporteId, fn ($q) => $q->where('esporte_id', $esporteId))
        ->whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])
        ->count();

    $diffOportunidades = $oportunidadesAtivasMesAtual - $oportunidadesAtivasMesAnterior;
    $percentOportunidades = $oportunidadesAtivasMesAnterior > 0
        ? round(($diffOportunidades / $oportunidadesAtivasMesAnterior) * 100, 2)
        : null;

    $proximoEvento = Evento::query()
        ->where('clube_id', $clube->id)
        ->where('data_hora_inicio', '>=', Carbon::now())
        ->orderBy('data_hora_inicio', 'asc')
        ->first([
            'id',
            'titulo',
            'descricao',
            'data_hora_inicio',
            'cidade',
            'estado',
            'color',
        ]);

    $eventosMesAtual = Evento::query()
        ->where('clube_id', $clube->id)
        ->whereBetween('data_hora_inicio', [$inicioMesAtual, $fimMesAtual])
        ->count();

    $eventosMesAnterior = Evento::query()
        ->where('clube_id', $clube->id)
        ->whereBetween('data_hora_inicio', [$inicioMesAnterior, $fimMesAnterior])
        ->count();

    $diffEventos = $eventosMesAtual - $eventosMesAnterior;
    $percentEventos = $eventosMesAnterior > 0
        ? round(($diffEventos / $eventosMesAnterior) * 100, 2)
        : null;

    $usuariosUnicosTotal = Usuario::query()
        ->whereHas('listas', function ($q) use ($clube) {
            $q->where('listas.clube_id', $clube->id);
        })
        ->distinct('usuarios.id')
        ->count('usuarios.id');

    $usuariosUnicosMesAtual = Usuario::query()
        ->whereHas('listas', function ($q) use ($clube, $inicioMesAtual, $fimMesAtual) {
            $q->where('listas.clube_id', $clube->id)
              ->whereBetween('listas.created_at', [$inicioMesAtual, $fimMesAtual]);
        })
        ->distinct('usuarios.id')
        ->count('usuarios.id');

    $usuariosUnicosMesAnterior = Usuario::query()
        ->whereHas('listas', function ($q) use ($clube, $inicioMesAnterior, $fimMesAnterior) {
            $q->where('listas.clube_id', $clube->id)
              ->whereBetween('listas.created_at', [$inicioMesAnterior, $fimMesAnterior]);
        })
        ->distinct('usuarios.id')
        ->count('usuarios.id');

    $diffUsuarios = $usuariosUnicosMesAtual - $usuariosUnicosMesAnterior;
    $percentUsuarios = $usuariosUnicosMesAnterior > 0
        ? round(($diffUsuarios / $usuariosUnicosMesAnterior) * 100, 2)
        : null;

    return [
        'inscricoes_pendentes' => [
            'mes_atual'   => $inscricoesPendentesMesAtual,
            'mes_anterior'=> $inscricoesPendentesMesAnterior,
            'diferenca'   => $diffInscricoes,
            'percentual'  => $percentInscricoes,
        ],
        'oportunidades_ativas' => [
            'total_ativo_agora' => $oportunidadesAtivasTotal,
            'mes_atual'         => $oportunidadesAtivasMesAtual,
            'mes_anterior'      => $oportunidadesAtivasMesAnterior,
            'diferenca'         => $diffOportunidades,
            'percentual'        => $percentOportunidades,
        ],
        'proximo_evento' => [
            'evento'       => $proximoEvento,
            'mes_atual'    => $eventosMesAtual,
            'mes_anterior' => $eventosMesAnterior,
            'diferenca'    => $diffEventos,
            'percentual'   => $percentEventos,
        ],
        'usuarios_unicos_listas' => [
            'total'        => $usuariosUnicosTotal,
            'mes_atual'    => $usuariosUnicosMesAtual,
            'mes_anterior' => $usuariosUnicosMesAnterior,
            'diferenca'    => $diffUsuarios,
            'percentual'   => $percentUsuarios,
        ],
    ];
}

    private function getInscricoesMensais($clube, $esporteId, $meses)
    {
        $inicio = Carbon::now()->subMonthsNoOverflow($meses - 1)->startOfMonth();

        $dados = Inscricao::query()
            ->join('oportunidades', 'inscricoes.oportunidade_id', '=', 'oportunidades.id')
            ->where('oportunidades.clube_id', $clube->id)
            ->where('inscricoes.created_at', '>=', $inicio)
            ->when($esporteId, fn($q) => $q->where('oportunidades.esporte_id', $esporteId))
            ->selectRaw('YEAR(inscricoes.created_at) as ano, MONTH(inscricoes.created_at) as mes, COUNT(*) as total')
            ->groupBy('ano', 'mes')
            ->orderBy('ano')->orderBy('mes')
            ->get();

        return $dados->map(fn($item) => [
            'rotulo' => str_pad($item->mes, 2, '0', STR_PAD_LEFT) . '/' . $item->ano,
            'total' => (int) $item->total,
        ]);
    }

    private function getTopEstados($clube, $esporteId)
    {
        return Inscricao::query()
            ->join('oportunidades', 'inscricoes.oportunidade_id', '=', 'oportunidades.id')
            ->join('usuarios', 'inscricoes.usuario_id', '=', 'usuarios.id')
            ->where('oportunidades.clube_id', $clube->id)
            ->when($esporteId, fn($q) => $q->where('oportunidades.esporte_id', $esporteId))
            ->selectRaw('usuarios.estadoUsuario as estado, COUNT(*) as total')
            ->groupBy('estado')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn($item) => ['estado' => $item->estado, 'total' => (int) $item->total]);
    }

    private function getAtividadesRecentes($clube, $esporteId, $perPage)
    {
        $oportunidades = Oportunidade::where('clube_id', $clube->id)
            ->with(['esporte:id,nomeEsporte', 'posicoes:id,nomePosicao'])
            ->when($esporteId, fn($q) => $q->where('esporte_id', $esporteId))
            ->orderByDesc('created_at')
            ->take($perPage)
            ->get();

        $inscricoes = Inscricao::with(['usuario:id,nomeCompletoUsuario', 'oportunidade:id,tituloOportunidades'])
            ->whereHas('oportunidade', function ($q) use ($clube, $esporteId) {
                $q->where('clube_id', $clube->id);
                if ($esporteId) $q->where('esporte_id', $esporteId);
            })
            ->orderByDesc('created_at')
            ->take($perPage)
            ->get();

        return compact('oportunidades', 'inscricoes');
    }

    private function getProximosEventos($clube, $limit = 1)
    {
        return Evento::where('clube_id', $clube->id)
            ->where('data_hora_inicio', '>=', Carbon::now())
            ->orderBy('data_hora_inicio', 'asc')
            ->limit($limit)
            ->withCount('convites')
            ->get();
    }

    private function getDistribuicaoPosicoes($clube, $esporteId)
    {
        $rows = Inscricao::query()
            ->join('oportunidades', 'inscricoes.oportunidade_id', '=', 'oportunidades.id')
            
            // 1. JOIN NA TABELA PIVÔ (onde ficam os IDs agora)
            ->join('oportunidades_posicoes', 'oportunidades.id', '=', 'oportunidades_posicoes.oportunidades_id')
            
            // 2. JOIN NA TABELA DE POSIÇÕES (para pegar o nome)
            ->join('posicoes', 'oportunidades_posicoes.posicoes_id', '=', 'posicoes.id')
            
            ->where('oportunidades.clube_id', $clube->id)
            ->when($esporteId, fn($q) => $q->where('oportunidades.esporte_id', $esporteId))
            
            // 3. SELECT DIRETO DO NOME E CONTAGEM
            ->selectRaw('posicoes.nomePosicao as posicao_nome, COUNT(inscricoes.id) as total')
            
            // 4. AGRUPAR PELO ID DA POSIÇÃO
            ->groupBy('posicoes.id', 'posicoes.nomePosicao')
            ->get();

        // Retorna direto (o map é opcional agora, mas mantive a estrutura do array)
        return $rows->map(function ($row) {
            return [
                'posicao_nome' => $row->posicao_nome,
                'total' => (int) $row->total,
            ];
        });
    }
}