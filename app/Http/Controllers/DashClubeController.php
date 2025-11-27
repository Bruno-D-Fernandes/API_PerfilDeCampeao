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

            $esporteId = $request->query('esporte_id', $clube->esporte()->get());
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
        $inscricoesPendentes = Inscricao::pending()
            ->whereHas('oportunidade', function ($q) use ($clube, $esporteId) {
                $q->where('clube_id', $clube->id);
                if ($esporteId) $q->where('esporte_id', $esporteId);
            })->count();

        $oportunidadesAtivas = Oportunidade::approved()
            ->where('clube_id', $clube->id)
            ->when($esporteId, fn($q) => $q->where('esporte_id', $esporteId))
            ->count();

        $proximoEvento = Evento::query()
            ->where('clube_id', $clube->id)
            ->where('data_hora_inicio', '>=', Carbon::now())
            ->orderBy('data_hora_inicio', 'asc')
            ->first(['id', 'titulo', 'descricao', 'data_hora_inicio', 'cidade', 'estado']);

        $usuariosUnicos = Usuario::query()
            ->whereHas('listas', fn($q) => $q->where('listas.clube_id', $clube->id))
            ->distinct('usuarios.id')
            ->count('usuarios.id');

        return compact('inscricoesPendentes', 'oportunidadesAtivas', 'proximoEvento', 'usuariosUnicos');
    }

    private function getDistribuicaoPosicoes($clube, $esporteId)
    {
        $rows = Inscricao::query()
            ->join('oportunidades', 'inscricoes.oportunidade_id', '=', 'oportunidades.id')
            ->where('oportunidades.clube_id', $clube->id)
            ->when($esporteId, fn($q) => $q->where('oportunidades.esporte_id', $esporteId))
            ->selectRaw('oportunidades.posicoes_id as posicao_id, COUNT(*) as total')
            ->groupBy('oportunidades.posicoes_id')
            ->get();

        $posicoes = Posicao::whereIn('id', $rows->pluck('posicao_id')->filter())->get()->keyBy('id');

        return $rows->map(function ($row) use ($posicoes) {
            $pos = $posicoes->get($row->posicao_id);
            return [
                'posicao_nome' => $pos?->nomePosicao ?? 'N/A',
                'total' => (int) $row->total,
            ];
        });
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
            ->with(['esporte:id,nomeEsporte', 'posicao:id,nomePosicao'])
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

    private function getProximosEventos($clube, $limit = 3)
    {
        return Evento::where('clube_id', $clube->id)
            ->where('data_hora_inicio', '>=', Carbon::now())
            ->orderBy('data_hora_inicio', 'asc')
            ->limit($limit)
            ->withCount('convites')
            ->get();
    }
}