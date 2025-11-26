<?php

namespace App\Http\Controllers;

use App\Events\NewPendingOpportunityEvent;
use Illuminate\Http\Request;
use App\Models\Oportunidade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use App\Models\Clube;
use Carbon\Carbon;

class OportunidadeController extends Controller
{
    public function showWebPage()
    {
        $oportunidades = Oportunidade::with('esporte', 'clube', 'posicao', 'inscricoes')->get();

        return view('admin.listas.oportunidades')->with(['oportunidades' => $oportunidades]);
    }

    /**
     * Cria uma nova oportunidade (somente clube autenticado)
     */


    //ALGUEM ME AJUDA PELO AMOR DE DEUS --ASS: Luan

    public function store(Request $request)
    {

        $clube = $request->user();

        if (!$clube || !($clube instanceof Clube)) {
            return response()->json([
                'message' => 'Apenas clubes autenticados podem criar oportunidades'
            ], 403);
        }

        $validatedData = $request->validate([
            'descricaoOportunidades'    => 'required|string|max:255',
            'esporte_id'                => 'required|exists:esportes,id',
            'posicoes_id'               => 'required|exists:posicoes,id',
            'idadeMinima'               => 'nullable|integer|min:0|max:120',
            'idadeMaxima'               => 'nullable|integer|min:0|max:120|gte:idadeMinima',
            'estadoOportunidade'        => 'nullable|string|size:2',
            'cidadeOportunidade'        => 'nullable|string|max:100',
            'enderecoOportunidade'      => 'nullable|string|max:255',
            'cepOportunidade'           => 'nullable|string|max:9',
        ]);

        try {

            $oportunidade = Oportunidade::create([
                'descricaoOportunidades'    => $validatedData['descricaoOportunidades'],
                'datapostagemOportunidades' => Carbon::now(),
                'esporte_id'                => $validatedData['esporte_id'],
                'posicoes_id'               => $validatedData['posicoes_id'],
                'clube_id'                  => $clube->id,
                'status'                    => Oportunidade::STATUS_PENDING,
                'idadeMinima'               => $validatedData['idadeMinima']        ?? null,
                'idadeMaxima'               => $validatedData['idadeMaxima']        ?? null,
                'estadoOportunidade'        => $validatedData['estadoOportunidade'] ?? null,
                'cidadeOportunidade'        => $validatedData['cidadeOportunidade'] ?? null,
                'enderecoOportunidade'      => $validatedData['enderecoOportunidade'] ?? null,
                'cepOportunidade'           => $validatedData['cepOportunidade']    ?? null,
            ]);

            event(new NewPendingOpportunityEvent($oportunidade, $clube));

            return response()->json($oportunidade->load('posicao', 'esporte', 'candidatos'), 201);
        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Erro interno ao criar oportunidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $usuario = Auth::guard('sanctum')->user();
        $query = Oportunidade::approved()->with(['esporte', 'posicao', 'clube'])->orderBy('created_at', 'asc');

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
        $perPage = $request->query('per_page', 10);
        $esporteId = $request->query('esporte_id');
        $estado = $request->query('estado');
        $idadeMinima = $request->query('idadeMinima');
        $idadeMaxima = $request->query('idadeMaxima');

        $query = Oportunidade::approved()->with(['esporte', 'posicao', 'clube']);

        if ($esporteId) {
            $query->where('esporte_id', $esporteId);
        }

        if ($estado) {
            $query->where('estadoOportunidade', $estado);
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
        $oportunidade = Oportunidade::with(['esporte', 'posicao', 'clube', 'inscricoes.usuario'])->find($id);

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
            'descricaoOportunidades'    => 'sometimes|required|string|max:255',
            'esporte_id'                => 'sometimes|required|exists:esportes,id',
            'posicoes_id'               => 'sometimes|required|exists:posicoes,id',
            'idadeMinima'               => 'sometimes|integer|min:0|max:120',
            'idadeMaxima'               => 'sometimes|integer|min:0|max:120|gte:idadeMinima',
            'estadoOportunidade'        => 'sometimes|string|size:2',
            'cidadeOportunidade'        => 'sometimes|string|max:100',
            'enderecoOportunidade'      => 'sometimes|string|max:255',
            'cepOportunidade'           => 'sometimes|string|max:9',
        ]);

        if ($oportunidade->status === Oportunidade::STATUS_REJECTED || $oportunidade->status === Oportunidade::STATUS_APPROVED) {
            $oportunidade->status = \App\Models\Oportunidade::STATUS_PENDING;
            $oportunidade->reviewed_by = null;
            $oportunidade->reviewed_at = null;
            $oportunidade->rejection_reason = null;
        }

        $oportunidade->fill($validatedData)->save();

        try {
            $oportunidade->update($validatedData);
            return response()->json([
                'message' => 'Oportunidade atualizada',
                'data'    => $oportunidade->load(['esporte', 'posicao', 'clube', 'candidatos']),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno ao atualizar oportunidade',
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
                'error' => 'Erro interno ao deletar oportunidade',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
