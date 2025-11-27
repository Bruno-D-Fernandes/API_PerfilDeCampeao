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
    /**
     * 5 últimos cadastros de usuários (já pronto)
     */
    public function dashboardData(Request $request)
    {
        try {
            // 1. Verificação de Segurança
            $admin = Auth::guard('admin')->user();

            if (! $admin instanceof Admin) {
                return response()->json(['message' => 'Admin não autorizado'], 403);
            }

            // 2. Parâmetros Globais
            $perPage = (int) $request->query('per_page', 5);
            $meses = (int) $request->query('months', 6);

            // Datas Auxiliares
            $agora = Carbon::now();
            $inicioMesAtual = $agora->copy()->startOfMonth();
            $fimMesAtual = $agora->copy()->endOfMonth();
            $inicioMesAnterior = $inicioMesAtual->copy()->subMonth();
            $fimMesAnterior = $inicioMesAtual->copy()->subDay();
            $inicioJanelaGraficos = $agora->copy()->subMonthsNoOverflow($meses - 1)->startOfMonth();

            // ============================================================
            // BLOCO A: RESUMO GERAL (KPIs)
            // ============================================================
            
            $atletasMesAtual = Usuario::whereBetween('created_at', [$inicioMesAtual, $fimMesAtual])->count();
            $atletasMesAnterior = Usuario::whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])->count();
            $diffAtletas = $atletasMesAtual - $atletasMesAnterior;
            $percentAtletas = $atletasMesAnterior > 0 ? round(($diffAtletas / $atletasMesAnterior) * 100, 2) : null;

            $clubesAtivosAtual = Clube::ativos()->count();
            $clubesAtivosMesAtual = Clube::ativos()->whereBetween('created_at', [$inicioMesAtual, $fimMesAtual])->count();
            $clubesAtivosMesAnterior = Clube::ativos()->whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])->count();
            $diffClubes = $clubesAtivosMesAtual - $clubesAtivosMesAnterior;
            $percentClubes = $clubesAtivosMesAnterior > 0 ? round(($diffClubes / $clubesAtivosMesAnterior) * 100, 2) : null;

            $resumo = [
                'atletas_mes' => [
                    'atual' => $atletasMesAtual,
                    'anterior' => $atletasMesAnterior,
                    'diferenca' => $diffAtletas,
                    'percentual' => $percentAtletas,
                ],
                'clubes_ativos' => [
                    'total_ativo_agora' => $clubesAtivosAtual,
                    'mes_atual' => $clubesAtivosMesAtual,
                    'mes_anterior' => $clubesAtivosMesAnterior,
                    'diferenca' => $diffClubes,
                    'percentual' => $percentClubes,
                ],
                'oportunidades_ativas' => Oportunidade::approved()->count(),
                'inscricoes_totais' => Inscricao::count(),
            ];

            // ============================================================
            // BLOCO B: GRÁFICOS
            // ============================================================

            // Crescimento Usuários
            $rawUsuarios = Usuario::query()
                ->where('created_at', '>=', $inicioJanelaGraficos)
                ->selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, COUNT(*) as total')
                ->groupBy('ano', 'mes')
                ->orderBy('ano')->orderBy('mes')
                ->get();
            
            $graficoUsuarios = $rawUsuarios->map(fn($item) => [
                'rotulo' => str_pad($item->mes, 2, '0', STR_PAD_LEFT) . '/' . $item->ano,
                'total' => (int) $item->total,
            ]);

            // Inscrições Mensais
            $rawInscricoes = Inscricao::query()
                ->where('created_at', '>=', $inicioJanelaGraficos)
                ->selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, COUNT(*) as total')
                ->groupBy('ano', 'mes')
                ->orderBy('ano')->orderBy('mes')
                ->get();

            $graficoInscricoes = $rawInscricoes->map(fn($item) => [
                'rotulo' => str_pad($item->mes, 2, '0', STR_PAD_LEFT) . '/' . $item->ano,
                'total' => (int) $item->total,
            ]);

            // Distribuição por Esporte
            $rawEsportes = Oportunidade::query()
                ->selectRaw('esporte_id, COUNT(*) as total')
                ->groupBy('esporte_id')
                ->with('esporte:id,nomeEsporte')
                ->get();

            $graficoEsportes = $rawEsportes->map(fn($item) => [
                'esporte_id' => $item->esporte_id,
                'esporte_nome' => optional($item->esporte)->nomeEsporte,
                'total' => (int) $item->total,
            ]);

            // ============================================================
            // BLOCO C: LISTAS (SEM PAGINAÇÃO)
            // ============================================================

            // C1. Últimos Cadastros (Usuários)
            $listaUsuarios = Usuario::query()
                ->orderByDesc('created_at')
                ->take($perPage)
                ->get(['id', 'nomeCompletoUsuario', 'emailUsuario', 'created_at', 'status']);

            // C2. Oportunidades com mais inscrições
            $listaOportunidadesTop = Oportunidade::query()
                ->with(['esporte:id,nomeEsporte', 'posicao:id,nomePosicao', 'clube:id,nomeClube,fotoPerfilClube'])
                ->withCount('inscricoes')
                ->orderByDesc('inscricoes_count')
                ->take($perPage)
                ->get(['id', 'tituloOportunidades', 'esporte_id', 'posicoes_id', 'clube_id', 'limite_inscricoes']);

            // C3. Clubes Mais Ativos
            $listaClubesTop = Clube::query()
                ->withCount('oportunidades')
                ->orderByDesc('oportunidades_count')
                ->take($perPage)
                ->get(['id', 'nomeClube', 'cidadeClube', 'estadoClube', 'fotoPerfilClube', 'status']);

            // C4. Atividades Recentes
            $recentOportunidades = Oportunidade::query()
                ->with(['clube:id,nomeClube', 'esporte:id,nomeEsporte'])
                ->orderByDesc('created_at')
                ->take($perPage)
                ->get(['id', 'tituloOportunidades', 'clube_id', 'esporte_id', 'created_at', 'status']);

            $recentInscricoes = Inscricao::query()
                ->with(['usuario:id,nomeCompletoUsuario', 'oportunidade:id,tituloOportunidades'])
                ->orderByDesc('created_at')
                ->take($perPage)
                ->get(['id', 'usuario_id', 'oportunidade_id', 'status', 'created_at']);

            // ============================================================
            // RESPOSTA FINAL
            // ============================================================

                return view('admin.dashboard', compact(
                'resumo',
                'graficoUsuarios',
                'graficoInscricoes',
                'graficoEsportes',
                'listaUsuarios',
                'listaOportunidadesTop',
                'listaClubesTop',
                'recentOportunidades',
                'recentInscricoes'
            ));

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao carregar dashboard: ' . $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTrace() : null
            ], 500);
        }
    }
}
