<?php

namespace App\Http\Controllers;

use App\Events\NewPendingOpportunityEvent;
use Illuminate\Http\Request;
use App\Models\Oportunidade;
use Illuminate\Support\Facades\Auth;
use App\Models\Clube;
use Carbon\Carbon;

class OportunidadeController extends Controller
{
    public function showWebPage(Request $request)
    {
        $user = $request->user();
        if (!$user instanceof Clube) {
            return redirect()->route('clube.login');
        }


        return view('admin.oportunidades.index');
    }

    public function store(Request $request)
    {
        $clube = $request->user();

        if (!$clube instanceof Clube) {
            return response()->json([
                'message' => 'Apenas clubes autenticados podem criar oportunidades'
            ], 403);
        }

        $validatedData = $request->validate([
            'limite_inscricoes'      => 'nullable|integer|min:1',
            'tituloOportunidades'    => 'required|string|max:100',
            'descricaoOportunidades' => 'required|string|max:255',
            'esporte_id'             => 'required|exists:esportes,id',
            'posicoes_ids'           => 'required|array|min:1',
            'posicoes_ids.*'         => 'exists:posicoes,id',
            'idadeMinima'            => 'nullable|integer|min:0|max:120',
            'idadeMaxima'            => 'nullable|integer|min:0|max:120|gte:idadeMinima',
        ]);

        try {
            $oportunidade = Oportunidade::create([
                'limite_inscricoes'      => $validatedData['limite_inscricoes'] ?? null,
                'tituloOportunidades'    => $validatedData['tituloOportunidades'],
                'descricaoOportunidades' => $validatedData['descricaoOportunidades'],
                'datapostagemOportunidades' => Carbon::now(),
                'esporte_id'             => $validatedData['esporte_id'],
                'clube_id'               => $clube->id,
                'status'                 => Oportunidade::STATUS_PENDING,
                'idadeMinima'            => $validatedData['idadeMinima'] ?? null,
                'idadeMaxima'            => $validatedData['idadeMaxima'] ?? null,
            ]);

            $oportunidade->posicoes()->sync($validatedData['posicoes_ids']);

            event(new NewPendingOpportunityEvent($oportunidade, $clube));

            return response()->json($oportunidade->load('posicoes', 'esporte', 'candidatos'), 201);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Erro interno ao criar oportunidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $usuario = Auth::guard('sanctum')->user();
        $query = Oportunidade::approved()->with(['esporte', 'posicoes', 'clube']);

        if ($usuario) {
            $query->whereDoesntHave('inscricoes', function ($q) use ($usuario) {
                $q->where('usuario_id', $usuario->id);
            });
        }

        $oportunidades = $query->paginate($perPage);
        $oportunidades->getCollection()->makeHidden(['status']);

        return response()->json($oportunidades, 200);
    }

    public function filtrar(Request $request)
    {
        $perPage     = $request->query('per_page', 10);
        $esporteId   = $request->query('esporte_id');
        $idadeMinima = $request->query('idadeMinima');
        $idadeMaxima = $request->query('idadeMaxima');

        $query = Oportunidade::approved()->with(['esporte', 'posicoes', 'clube']);

        $esporteNome = $request->query('esporte');

        if ($esporteNome) {
            $query->whereHas('esporte', function ($q) use ($esporteNome) {
                $q->where('nomeEsporte', 'LIKE', $esporteNome);
            });
        }

        if ($idadeMinima) {
            $idadeMinima = (int) $idadeMinima;
            $query->where(function ($q) use ($idadeMinima) {
                $q->whereNull('idadeMaxima')
                    ->orWhere('idadeMaxima', '>=', $idadeMinima);
            });
        }

        if ($idadeMaxima) {
            $idadeMaxima = (int) $idadeMaxima;
            $query->where(function ($q) use ($idadeMaxima) {
                $q->whereNull('idadeMinima')
                    ->orWhere('idadeMinima', '<=', $idadeMaxima);
            });
        }

        $oportunidades = $query->paginate($perPage);
        $oportunidades->getCollection()->makeHidden(['status']);

        return response()->json($oportunidades, 200);
    }

    public function show($id)
    {
        $oportunidade = Oportunidade::with(['esporte', 'posicoes', 'clube', 'inscricoes.usuario'])->find($id);

        if (!$oportunidade) {
            return response()->json(['message' => 'Oportunidade não encontrada'], 404);
        }

        return response()->json($oportunidade, 200);
    }

    public function update(Request $request, $id)
    {
        $oportunidade = Oportunidade::find($id);

        if (!$oportunidade) {
            return response()->json(['message' => 'Oportunidade não encontrada'], 404);
        }

        $clube = $request->user();

        if (!$clube || !($clube instanceof Clube) || $oportunidade->clube_id !== $clube->id) {
            return response()->json(['message' => 'Apenas o clube que criou a oportunidade pode atualizá-la'], 403);
        }

        $validatedData = $request->validate([
            'limite_inscricoes'      => 'sometimes|nullable|integer|min:1',
            'tituloOportunidades'    => 'sometimes|required|string|max:100',
            'descricaoOportunidades' => 'sometimes|required|string|max:255',
            'esporte_id'             => 'sometimes|required|exists:esportes,id',
            'posicoes_ids'           => 'sometimes|array|min:1',
            'posicoes_ids.*'         => 'exists:posicoes,id',
            'idadeMinima'            => 'sometimes|integer|min:0|max:120',
            'idadeMaxima'            => 'sometimes|integer|min:0|max:120|gte:idadeMinima',
        ]);

        if ($oportunidade->status === Oportunidade::STATUS_REJECTED || $oportunidade->status === Oportunidade::STATUS_APPROVED) {
            $oportunidade->status         = Oportunidade::STATUS_PENDING;
            $oportunidade->reviewed_by    = null;
            $oportunidade->reviewed_at    = null;
            $oportunidade->rejection_reason = null;
        }

        try {
            $oportunidade->fill($validatedData);
            $oportunidade->save();

            if (array_key_exists('posicoes_ids', $validatedData)) {
                $oportunidade->posicoes()->sync($validatedData['posicoes_ids']);
            }

            return response()->json([
                'message' => 'Oportunidade atualizada',
                'data'    => $oportunidade->load(['esporte', 'posicoes', 'clube', 'candidatos']),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Erro interno ao atualizar oportunidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $oportunidade = Oportunidade::find($id);

        if (!$oportunidade) {
            return response()->json(['message' => 'Oportunidade não encontrada'], 404);
        }

        $clube = $request->user();
        if (!$clube || !($clube instanceof Clube) || $oportunidade->clube_id !== $clube->id) {
            return response()->json(['message' => 'Apenas o clube que criou a oportunidade pode deletá-la'], 403);
        }

        try {
            $oportunidade->delete();
            return response()->json(['message' => 'Oportunidade deletada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Erro interno ao deletar oportunidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
