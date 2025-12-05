<?php

namespace App\Http\Controllers;

use App\Events\OpportunityStatusChangeEvent;
use App\Models\Inscricao;
use App\Models\Oportunidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminOportunidadesController extends Controller
{
    public function index()
    {
        return view('admin.oportunidades.index');
    }

    public function metrics(Request $request)
    {
        // DEBUG: ver no log se está contando certo
        $total    = Oportunidade::withoutGlobalScopes()->count();
        $approved = Oportunidade::withoutGlobalScopes()->where('status', 'approved')->count();
        $pending  = Oportunidade::withoutGlobalScopes()->where('status', 'pending')->count();
        $rejected = Oportunidade::withoutGlobalScopes()->where('status', 'rejected')->count();

        Log::info('ADMIN OPORTUNIDADES METRICS', [
            'total'    => $total,
            'approved' => $approved,
            'pending'  => $pending,
            'rejected' => $rejected,
        ]);

        return response()->json([
            'total'    => $total,
            'approved' => $approved,
            'pending'  => $pending,
            'rejected' => $rejected,
        ], 200);
    }

    public function list(Request $request)
    {
        $status   = $request->query('status');
        $search   = $request->query('search');
        $perPage  = (int) $request->query('per_page', 15);
        $sortCol  = $request->query('sort_col');
        $sortDir  = $request->query('sort_dir');

        $q = Oportunidade::withoutGlobalScopes()
            ->with([
                'clube:id,nomeClube,fotoPerfilClube,cidadeClube,estadoClube',
                'esporte:id,nomeEsporte',
                'posicoes:id,nomePosicao',
            ])
            ->withCount([
                'inscricoes',
                'inscricoesAprovadas as inscricoes_aprovadas_count',
                'inscricoesRejeitadas as inscricoes_rejeitadas_count',
                'inscricoesPendentes as inscricoes_pendentes_count',
            ]);

        // Filtro por status
        if ($status && $status !== 'all') {
            $q->where('status', $status);
        }

        // Busca por título, clube ou esporte
        if ($search) {
            $q->where(function ($w) use ($search) {
                $w->where('tituloOportunidades', 'like', "%{$search}%")
                    ->orWhereHas('clube', function ($qq) use ($search) {
                        $qq->where('nomeClube', 'like', "%{$search}%");
                    })
                    ->orWhereHas('esporte', function ($qq) use ($search) {
                        $qq->where('nomeEsporte', 'like', "%{$search}%");
                    });
            });
        }

        // Colunas de ordenação
        $allowedColumns = [
            'id',
            'tituloOportunidades',
            'status',
            'inscricoes_count',
            'created_at',
        ];

        if (
            $sortCol &&
            in_array($sortCol, $allowedColumns, true) &&
            in_array($sortDir, ['asc', 'desc'], true)
        ) {
            $q->orderBy($sortCol, $sortDir);
        } else {
            $q->orderByDesc('created_at');
        }

        $paginado = $q->paginate($perPage);

        // DEBUG: ver no log se está vindo coisa
        Log::info('ADMIN OPORTUNIDADES LIST', [
            'total'           => $paginado->total(),
            'per_page'        => $paginado->perPage(),
            'current_page'    => $paginado->currentPage(),
            'count_this_page' => $paginado->count(),
        ]);

        return response()->json($paginado, 200);
    }

    public function show(Request $request, Oportunidade $oportunidade)
    {
        $oportunidade->load([
            'clube:id,nomeClube,fotoPerfilClube,cidadeClube,estadoClube,emailClube',
            'esporte:id,nomeEsporte',
            'posicoes:id,nomePosicao',
            'reviewer:id,nome',
        ])->loadCount([
            'inscricoes',
            'inscricoesAprovadas as inscricoes_aprovadas_count',
            'inscricoesRejeitadas as inscricoes_rejeitadas_count',
            'inscricoesPendentes as inscricoes_pendentes_count',
        ]);

        return response()->json($oportunidade, 200);
    }

    public function update(Request $request, Oportunidade $oportunidade)
    {
        $data = $request->validate([
            'tituloOportunidades'        => ['sometimes', 'required', 'string', 'max:255'],
            'descricaoOportunidades'     => ['sometimes', 'nullable', 'string'],
            'datapostagemOportunidades'  => ['sometimes', 'nullable', 'date'],
            'esporte_id'                 => ['sometimes', 'nullable', 'exists:esportes,id'],
            'clube_id'                   => ['sometimes', 'nullable', 'exists:clubes,id'],
            'idadeMinima'                => ['sometimes', 'nullable', 'integer', 'min:0'],
            'idadeMaxima'                => ['sometimes', 'nullable', 'integer', 'min:0'],
            'limite_inscricoes'          => ['sometimes', 'nullable', 'integer', 'min:0'],
            'posicoes_ids'               => ['sometimes', 'array'],
            'posicoes_ids.*'             => ['integer', 'exists:posicoes,id'],
            'status'                     => ['sometimes', 'string'],
            'rejection_reason'           => ['sometimes', 'nullable', 'string', 'max:1000'],
        ]);

        $posicoesIds = $data['posicoes_ids'] ?? null;
        unset($data['posicoes_ids']);

        if (!empty($data)) {
            $oportunidade->update($data);
        }

        if (is_array($posicoesIds)) {
            $oportunidade->posicoes()->sync($posicoesIds);
        }

        $oportunidade->load([
            'clube:id,nomeClube,fotoPerfilClube,cidadeClube,estadoClube',
            'esporte:id,nomeEsporte',
            'posicoes:id,nomePosicao',
        ])->loadCount([
            'inscricoes',
            'inscricoesAprovadas as inscricoes_aprovadas_count',
            'inscricoesRejeitadas as inscricoes_rejeitadas_count',
            'inscricoesPendentes as inscricoes_pendentes_count',
        ]);

        return response()->json($oportunidade, 200);
    }

    public function updateStatus(Request $request, Oportunidade $oportunidade)
    {
        $data = $request->validate([
            'status' => [
                'required',
                Rule::in(['approved', 'rejected']),
            ],
            'rejection_reason' => [
                'nullable',
                Rule::requiredIf(fn () => $request->status === 'rejected'),
                'string',
                'max:1000',
            ],
        ]);

       

        $oportunidade->status = $data['status'];

        if ($data['status'] === 'rejected') {
            $oportunidade->rejection_reason = $data['rejection_reason'];
        } else {
            $oportunidade->rejection_reason = null;
        }

        $oportunidade->save();

        event(new OpportunityStatusChangeEvent(
            $oportunidade->clube,
            $oportunidade,
            $oportunidade->status
        ));

        $oportunidade->load([
            'clube:id,nomeClube,fotoPerfilClube,cidadeClube,estadoClube',
            'esporte:id,nomeEsporte',
            'posicoes:id,nomePosicao',
            'reviewer:id,nome',
        ])->loadCount([
            'inscricoes',
            'inscricoesAprovadas as inscricoes_aprovadas_count',
            'inscricoesRejeitadas as inscricoes_rejeitadas_count',
            'inscricoesPendentes as inscricoes_pendentes_count',
        ]);

        return response()->json($oportunidade, 200);
    }

    public function listInscricoes(Request $request, Oportunidade $oportunidade)
    {
        $perPage = (int) $request->query('per_page', 15);
        $status  = $request->query('status');
        $search  = $request->query('search');

        $q = Inscricao::with([
            'usuario:id,nomeCompletoUsuario,emailUsuario,estadoUsuario,cidadeUsuario,dataNascimentoUsuario,alturaCm,pesoKg',
        ])->where('oportunidade_id', $oportunidade->id);

        if ($status && $status !== 'all') {
            $q->where('status', $status);
        }

        if ($search) {
            $q->whereHas('usuario', function ($w) use ($search) {
                $w->where('nomeCompletoUsuario', 'like', "%{$search}%")
                    ->orWhere('emailUsuario', 'like', "%{$search}%");
            });
        }

        $inscricoes = $q
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return response()->json($inscricoes, 200);
    }

    public function destroy(Request $request, Oportunidade $oportunidade)
    {
        $oportunidade->delete();

        return response()->json(['message' => 'Oportunidade deletada com sucesso'], 200);
    }
}
