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

class DashAdminController extends Controller
{
    /**
     * 5 últimos cadastros de usuários (já pronto)
     */
    public function ultimosCadastros(Request $request)
    {
        try {
            $user = $request->user();
            if (! $user instanceof Admin) {
                return response()->json(['message' => 'Admin não autorizado'], 403);
            }

            $per_page = (int) $request->query('per_page', 5);

            $usuarios = Usuario::query()
                ->orderByDesc('created_at')
                ->paginate($per_page, [
                    'id',
                    'nomeCompletoUsuario',
                    'emailUsuario',
                    'created_at',
                    'status',
                ]);

            return response()->json($usuarios, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function oportunidadesInscricoes(Request $request)
    {
        try {
            $user = $request->user();
            if (! $user instanceof Admin) {
                return response()->json(['message' => 'Admin não autorizado'], 403);
            }

            $per_page = (int) $request->query('per_page', 5);

            $oportunidades = Oportunidade::query()
                ->with([
                    'esporte:id,nomeEsporte',
                    'posicao:id,nomePosicao',
                    'clube:id,nomeClube,fotoPerfilClube',
                ])
                ->withCount('inscricoes')
                ->orderByDesc('inscricoes_count')
                ->paginate($per_page, [
                    'id',
                    'tituloOportunidades',
                    'esporte_id',
                    'posicoes_id',
                    'clube_id',
                    'limite_inscricoes',
                ]);

            return response()->json($oportunidades, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function clubesMaisAtivos(Request $request)
    {
        try {
            $user = $request->user();
            if (! $user instanceof Admin) {
                return response()->json(['message' => 'Admin não autorizado'], 403);
            }

            $per_page = (int) $request->query('per_page', 5);

            $clubes = Clube::query()
                ->withCount('oportunidades')
                ->orderByDesc('oportunidades_count')
                ->paginate($per_page, [
                    'id',
                    'nomeClube',
                    'cidadeClube',
                    'estadoClube',
                    'fotoPerfilClube',
                    'status',
                ]);

            return response()->json([
                'data' => $clubes,
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
        $user = $request->user();
        if (! $user instanceof Admin) {
            return response()->json(['message' => 'Admin não autorizado'], 403);
        }

        $per_page = (int) $request->query('per_page', 5);

        $ultimasOportunidades = Oportunidade::query()
            ->with(['clube:id,nomeClube', 'esporte:id,nomeEsporte']) // TODO
            ->orderByDesc('created_at')
            ->paginate($per_page, [
                'id',
                'tituloOportunidades',
                'clube_id',
                'esporte_id',
                'created_at',
                'status',
            ]);

        $ultimasInscricoes = Inscricao::query() // TODO: confirme model
            ->with([
                'usuario:id,nomeCompletoUsuario', // TODO
                'oportunidade:id,tituloOportunidades',
            ])
            ->orderByDesc('created_at')
            ->paginate($per_page, [
                'id',
                'usuario_id',
                'oportunidade_id',
                'status',   // TODO
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

    /**
     * Resumo geral da dash (números grandes / cards):
     * - número de atletas cadastrados no mês + variação vs mês anterior
     * - número de clubes ativos + variação vs mês anterior
     * - número de oportunidades ativas
     * - número total de inscrições realizadas
     */
    public function resumoGeral(Request $request)
{
    try {
        $user = $request->user();
        if (! $user instanceof Admin) {
            return response()->json(['message' => 'Admin não autorizado'], 403);
        }

        $agora = Carbon::now();
        $inicioMesAtual   = $agora->copy()->startOfMonth();
        $fimMesAtual      = $agora->copy()->endOfMonth();

        $inicioMesAnterior = $inicioMesAtual->copy()->subMonth();
        $fimMesAnterior    = $inicioMesAtual->copy()->subDay();

        // ATLETAS CADASTRADOS NO MÊS (todos usuários por enquanto)
        $atletasMesAtual = Usuario::query()
            ->whereBetween('created_at', [$inicioMesAtual, $fimMesAtual])
            ->count();

        $atletasMesAnterior = Usuario::query()
            ->whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])
            ->count();

        $diffAtletas = $atletasMesAtual - $atletasMesAnterior;
        $percentAtletas = $atletasMesAnterior > 0
            ? round(($diffAtletas / $atletasMesAnterior) * 100, 2)
            : null;

        // CLUBES ATIVOS
        $clubesAtivosAtual = Clube::ativos()->count();

        $clubesAtivosMesAtual = Clube::ativos()
            ->whereBetween('created_at', [$inicioMesAtual, $fimMesAtual])
            ->count();

        $clubesAtivosMesAnterior = Clube::ativos()
            ->whereBetween('created_at', [$inicioMesAnterior, $fimMesAnterior])
            ->count();

        $diffClubes = $clubesAtivosMesAtual - $clubesAtivosMesAnterior;
        $percentClubes = $clubesAtivosMesAnterior > 0
            ? round(($diffClubes / $clubesAtivosMesAnterior) * 100, 2)
            : null;

        // OPORTUNIDADES ATIVAS (approved)
        $oportunidadesAtivas = Oportunidade::approved()->count();

        // INSCRIÇÕES TOTAIS
        $inscricoesTotais = Inscricao::query()->count();

        return response()->json([
            'atletas_mes' => [
                'atual'      => $atletasMesAtual,
                'anterior'   => $atletasMesAnterior,
                'diferenca'  => $diffAtletas,
                'percentual' => $percentAtletas,
            ],
            'clubes_ativos' => [
                'total_ativo_agora' => $clubesAtivosAtual,
                'mes_atual'         => $clubesAtivosMesAtual,
                'mes_anterior'      => $clubesAtivosMesAnterior,
                'diferenca'         => $diffClubes,
                'percentual'        => $percentClubes,
            ],
            'oportunidades_ativas' => $oportunidadesAtivas,
            'inscricoes_totais'    => $inscricoesTotais,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
        ], 500);
    }
}

    public function crescimentoUsuariosMensal(Request $request)
    {
        try {
            $user = $request->user();
            if (! $user instanceof Admin) {
                return response()->json(['message' => 'Admin não autorizado'], 403);
            }

            $meses = (int) $request->query('months', 6);

            $inicioJanela = Carbon::now()
                ->copy()
                ->subMonthsNoOverflow($meses - 1)
                ->startOfMonth();

            $dados = Usuario::query()
                ->where('created_at', '>=', $inicioJanela)
                ->selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, COUNT(*) as total')
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
    public function inscricoesMensais(Request $request)
    {
        try {
            $user = $request->user();
            if (! $user instanceof Admin) {
                return response()->json(['message' => 'Admin não autorizado'], 403);
            }

            $meses = (int) $request->query('months', 6);

            $inicioJanela = Carbon::now()
                ->copy()
                ->subMonthsNoOverflow($meses - 1)
                ->startOfMonth();

            $dados = Inscricao::query()
                ->where('created_at', '>=', $inicioJanela)
                ->selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, COUNT(*) as total')
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

    public function distribuicaoOportunidadesPorEsporte(Request $request)
    {
        try {
            $user = $request->user();
            if (! $user instanceof Admin) {
                return response()->json(['message' => 'Admin não autorizado'], 403);
            }

            $dados = Oportunidade::query()
                ->selectRaw('esporte_id, COUNT(*) as total')
                ->groupBy('esporte_id')
                ->with('esporte:id,nomeEsporte')
                ->get();

            $series = $dados->map(function ($item) {
                return [
                    'esporte_id'   => $item->esporte_id,
                    'esporte_nome' => optional($item->esporte)->nomeEsporte, // TODO: ajuste nome se necessário
                    'total'        => (int) $item->total,
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
}
