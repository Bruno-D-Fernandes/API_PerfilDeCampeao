<?php

namespace App\Http\Controllers;

use App\Events\OpportunityStatusChangeEvent;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Oportunidade;
use App\Models\Usuario;
use App\Models\Clube;
use App\Models\Categoria;
use App\Models\Lista;
use App\Models\Caracteristica;
use App\Models\Esporte;
use App\Models\Funcao;
use App\Models\Posicao;
use App\Models\Inscricao;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashAdminController extends Controller
{
    public function dashboardData(Request $request)
    {
        try {
            Carbon::setLocale('pt_BR');

            $admin = Auth::guard('admin')->user();

            $perPage = (int) $request->query('per_page', 5);
            $meses = (int) $request->query('months', 6);

            $agora = Carbon::now();
            $inicioMesAtual = $agora->copy()->startOfMonth();
            $fimMesAtual = $agora->copy()->endOfMonth();
            $inicioMesAnterior = $inicioMesAtual->copy()->subMonth();
            $fimMesAnterior = $inicioMesAtual->copy()->subDay();
            $inicioJanelaGraficos = $agora->copy()->subMonthsNoOverflow($meses - 1)->startOfMonth();

            $atletasMesAtual = Usuario::whereBetween('created_at', [$inicioMesAtual, $fimMesAtual])->count();
            $atletasMesAnterior = Usuario::whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])->count();
            $diffAtletas = $atletasMesAtual - $atletasMesAnterior;
            $percentAtletas = $atletasMesAnterior > 0 ? round(($diffAtletas / $atletasMesAnterior) * 100, 2) : null;

            $clubesAtivosAtual = Clube::ativos()->count();
            $clubesAtivosMesAtual = Clube::ativos()->whereBetween('created_at', [$inicioMesAtual, $fimMesAtual])->count();
            $clubesAtivosMesAnterior = Clube::ativos()->whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])->count();
            $diffClubes = $clubesAtivosMesAtual - $clubesAtivosMesAnterior;
            $percentClubes = $clubesAtivosMesAnterior > 0 ? round(($diffClubes / $clubesAtivosMesAnterior) * 100, 2) : null;

            $oportunidadesAprovadasTotal = Oportunidade::approved()->count();
            $oportunidadesMesAtual = Oportunidade::approved()
                ->whereBetween('created_at', [$inicioMesAtual, $fimMesAtual])
                ->count();
            $oportunidadesMesAnterior = Oportunidade::approved()
                ->whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])
                ->count();
            $diffOportunidades = $oportunidadesMesAtual - $oportunidadesMesAnterior;
            $percentOportunidades = $oportunidadesMesAnterior > 0
                ? round(($diffOportunidades / $oportunidadesMesAnterior) * 100, 2)
                : null;

            $inscricoesTotais = Inscricao::count();
            $inscricoesMesAtual = Inscricao::whereBetween('created_at', [$inicioMesAtual, $fimMesAtual])->count();
            $inscricoesMesAnterior = Inscricao::whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])->count();
            $diffInscricoes = $inscricoesMesAtual - $inscricoesMesAnterior;
            $percentInscricoes = $inscricoesMesAnterior > 0
                ? round(($diffInscricoes / $inscricoesMesAnterior) * 100, 2)
                : null;

            $resumo = [
                'atletas_mes' => [
                    'mes_atual'    => $atletasMesAtual,
                    'mes_anterior' => $atletasMesAnterior,
                    'diferenca'    => $diffAtletas,
                    'percentual'   => $percentAtletas,
                ],
                'clubes_ativos' => [
                    'total_ativo_agora' => $clubesAtivosAtual,
                    'mes_atual'         => $clubesAtivosMesAtual,
                    'mes_anterior'      => $clubesAtivosMesAnterior,
                    'diferenca'         => $diffClubes,
                    'percentual'        => $percentClubes,
                ],
                'oportunidades_ativas' => [
                    'total_ativo_agora' => $oportunidadesAprovadasTotal,
                    'mes_atual'         => $oportunidadesMesAtual,
                    'mes_anterior'      => $oportunidadesMesAnterior,
                    'diferenca'         => $diffOportunidades,
                    'percentual'        => $percentOportunidades,
                ],
                'inscricoes_totais' => [
                    'total'        => $inscricoesTotais,
                    'mes_atual'    => $inscricoesMesAtual,
                    'mes_anterior' => $inscricoesMesAnterior,
                    'diferenca'    => $diffInscricoes,
                    'percentual'   => $percentInscricoes,
                ],
            ];

            $serieCompleta = collect();
            $dataAtual = $inicioJanelaGraficos->copy();

            for ($i = 0; $i < $meses; $i++) {
                $rotulo = ucfirst($dataAtual->isoFormat('MMM'));
                $serieCompleta->put($rotulo, [
                    'rotulo' => $rotulo,
                    'total'  => 0,
                ]);
                $dataAtual->addMonth();
            }

            $rawUsuarios = Usuario::query()
                ->where('created_at', '>=', $inicioJanelaGraficos)
                ->selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, COUNT(*) as total')
                ->groupBy('ano', 'mes')
                ->orderBy('ano')->orderBy('mes')
                ->get();

            $dadosDoBancoFormatados = $rawUsuarios->mapWithKeys(function ($item) {
                $data = Carbon::createFromDate($item->ano, $item->mes, 1);
                $rotulo = ucfirst($data->isoFormat('MMM'));
                return [
                    $rotulo => [
                        'rotulo' => $rotulo,
                        'total'  => (int) $item->total,
                    ],
                ];
            });

            $graficoUsuarios = $serieCompleta->merge($dadosDoBancoFormatados)->values();

            $serieCompletaInscricoes = collect();
            $dataAtualInscricoes = $inicioJanelaGraficos->copy();

            for ($i = 0; $i < $meses; $i++) {
                $rotulo = ucfirst($dataAtualInscricoes->isoFormat('MMM'));
                $serieCompletaInscricoes->put($rotulo, [
                    'rotulo' => $rotulo,
                    'total'  => 0,
                ]);
                $dataAtualInscricoes->addMonth();
            }

            $rawInscricoes = Inscricao::query()
                ->where('created_at', '>=', $inicioJanelaGraficos)
                ->selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, COUNT(*) as total')
                ->groupBy('ano', 'mes')
                ->orderBy('ano')->orderBy('mes')
                ->get();

            $dadosDoBancoInscricoesFormatados = $rawInscricoes->mapWithKeys(function ($item) {
                $data = Carbon::createFromDate($item->ano, $item->mes, 1);
                $rotulo = ucfirst($data->isoFormat('MMM'));
                return [
                    $rotulo => [
                        'rotulo' => $rotulo,
                        'total'  => (int) $item->total,
                    ],
                ];
            });

            $graficoInscricoes = $serieCompletaInscricoes
                ->merge($dadosDoBancoInscricoesFormatados)
                ->values();

            $rawEsportes = Oportunidade::query()
                ->selectRaw('esporte_id, COUNT(*) as total')
                ->groupBy('esporte_id')
                ->with('esporte:id,nomeEsporte')
                ->orderByDesc('total')
                ->get();

            $graficoEsportes = $rawEsportes->map(function ($item) {
                return [
                    'esporte_id'   => $item->esporte_id,
                    'esporte_nome' => optional($item->esporte)->nomeEsporte,
                    'total'        => (int) $item->total,
                ];
            });

            $listaUsuarios = Usuario::query()
                ->orderByDesc('created_at')
                ->take(3)
                ->get(['id', 'nomeCompletoUsuario', 'emailUsuario', 'created_at', 'status']);

            $listaOportunidadesTop = Oportunidade::query()
                ->with(['esporte:id,nomeEsporte', 'posicao:id,nomePosicao', 'clube:id,nomeClube,fotoPerfilClube'])
                ->withCount('inscricoes')
                ->orderByDesc('inscricoes_count')
                ->take(3)
                ->get([
                    'id',
                    'tituloOportunidades',
                    'esporte_id',
                    'posicoes_id',
                    'clube_id',
                    'limite_inscricoes',
                    'inscricoes_count',
                ]);

            $listaClubesTop = Clube::query()
                ->withCount('oportunidades')
                ->orderByDesc('oportunidades_count')
                ->take(3)
                ->get([
                    'id',
                    'nomeClube',
                    'cidadeClube',
                    'estadoClube',
                    'fotoPerfilClube',
                    'status',
                    'oportunidades_count',
                ]);

            $recentOportunidades = Oportunidade::query()
                ->with(['clube:id,nomeClube', 'esporte:id,nomeEsporte'])
                ->orderByDesc('created_at')
                ->take($perPage)
                ->get([
                    'id',
                    'tituloOportunidades',
                    'clube_id',
                    'esporte_id',
                    'created_at',
                    'status',
                ]);

            $recentInscricoes = Inscricao::query()
                ->with(['usuario:id,nomeCompletoUsuario', 'oportunidade:id,tituloOportunidades'])
                ->orderByDesc('created_at')
                ->take($perPage)
                ->get([
                    'id',
                    'usuario_id',
                    'oportunidade_id',
                    'status',
                    'created_at',
                ]);

            $atividadesRecentes = $recentOportunidades
                ->merge($recentInscricoes)
                ->sortByDesc('created_at')
                ->take($perPage);

            return view('admin.dashboard', compact(
                'resumo',
                'graficoUsuarios',
                'graficoInscricoes',
                'graficoEsportes',
                'listaUsuarios',
                'listaOportunidadesTop',
                'listaClubesTop',
                'atividadesRecentes',
            ));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao carregar dashboard: ' . $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTrace() : null,
            ], 500);
        }
    }
}
