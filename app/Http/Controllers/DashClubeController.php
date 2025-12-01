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
    public function index(Request $request)
    {
        $clube = Auth::guard('club')->user();

        $clube->load(['esportes', 'esportesExtras']);

        $esportes = $clube->esportes->merge($clube->esportesExtras);

        if ($esportes->isEmpty()) {
            $esportes = \App\Models\Esporte::all();
        }

        $esportePadrao = $esportes->first();

        $dados = null;

        if ($esportePadrao) {
            $dados = $this->fetchDashboardData($clube, $esportePadrao->id);
        }

        return view('clube.dashboard', [
            'esportes' => $esportes,
            'esporteAtual' => $esportePadrao,
            'dados' => $dados
        ]);
    }

    public function loadContent(Request $request, $esporteId)
    {
        $clube = Auth::guard('club')->user();
        
        $dados = $this->fetchDashboardData($clube, $esporteId);
        $esporte = \App\Models\Esporte::find($esporteId);

        $html = view('clube.partials.dashboard-content', [
            'dados' => $dados,
            'esporte' => $esporte 
        ])->render();

        return response()->json(['html' => $html]);
    }

    private function fetchDashboardData($clube, $esporteId)
    {
        $meses = 6;
        $perPage = 5;

        return [
            'resumo' => $this->getResumoGeral($clube, $esporteId),
            'distribuicaoPosicoes' => $this->getDistribuicaoPosicoes($clube, $esporteId),
            'inscricoesMensais' => $this->getInscricoesMensais($clube, $esporteId, $meses),
            'topEstados' => $this->getTopEstados($clube, $esporteId),
            'atividadesRecentes' => $this->getAtividadesRecentes($clube, $esporteId, $perPage),
            'proximosEventos' => $this->getProximosEventos($clube, 1),
        ];
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
        $linhaDoTempo = collect();
        $dataAtual = Carbon::now()->startOfMonth();

        for ($i = $meses - 1; $i >= 0; $i--) {
            $data = $dataAtual->copy()->subMonthsNoOverflow($i)->locale('pt_BR');
            
            $chave = $data->format('Y-m'); 
            
            $linhaDoTempo->put($chave, [
                'rotulo' => ucfirst($data->translatedFormat('M')),
                'total'  => 0
            ]);
        }

        $dataInicio = $dataAtual->copy()->subMonthsNoOverflow($meses - 1);

        $registrosBanco = Inscricao::query()
            ->join('oportunidades', 'inscricoes.oportunidade_id', '=', 'oportunidades.id')
            ->where('oportunidades.clube_id', $clube->id)
            ->where('inscricoes.created_at', '>=', $dataInicio)
            ->when($esporteId, fn($q) => $q->where('oportunidades.esporte_id', $esporteId))
            ->selectRaw('YEAR(inscricoes.created_at) as ano, MONTH(inscricoes.created_at) as mes, COUNT(*) as total')
            ->groupBy('ano', 'mes')
            ->get();

        foreach ($registrosBanco as $registro) {
            $chave = $registro->ano . '-' . str_pad($registro->mes, 2, '0', STR_PAD_LEFT);

            if ($linhaDoTempo->has($chave)) {
                $item = $linhaDoTempo->get($chave);
                $item['total'] = (int) $registro->total;
                $linhaDoTempo->put($chave, $item);
            }
        }

        return $linhaDoTempo->values();
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