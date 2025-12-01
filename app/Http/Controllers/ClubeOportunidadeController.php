<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oportunidade;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClubeOportunidadeController extends Controller
{
    public function index()
    {
        $clube = Auth::guard('club')->user();
        
        $oportunidades = $clube->oportunidades()
            ->with(['esporte', 'posicoes']) 
            ->latest()
            ->get();

        $esportes = \App\Models\Esporte::with('posicoes')->get(); 

        return view('clube.oportunidades.index', compact('oportunidades', 'esportes'));
    }

    public function store(Request $request)
    {
        $clube = Auth::guard('club')->user();

        $validatedData = $request->validate([
            'tituloOportunidades'    => 'required|string|max:100',
            'descricaoOportunidades' => 'required|string|max:255',
            'esporte_id'             => 'required|exists:esportes,id',
            'posicoes_ids'   => 'required|array|min:1', 
            'posicoes_ids.*' => 'exists:posicoes,id',
            'idadeMinima'            => 'nullable|integer|min:0|max:120',
            'idadeMaxima'            => 'nullable|integer|min:0|max:120',
            'limite_inscricoes'      => 'required|integer|min:1',
        ]);

        try {
            $oportunidade = Oportunidade::create([
                'tituloOportunidades'       => $validatedData['tituloOportunidades'],
                'descricaoOportunidades'    => $validatedData['descricaoOportunidades'],
                'esporte_id'                => $validatedData['esporte_id'],
                'limite_inscricoes'         => $validatedData['limite_inscricoes'],
                'idadeMinima'               => $validatedData['idadeMinima'] ?? null,
                'idadeMaxima'               => $validatedData['idadeMaxima'] ?? null,
                'datapostagemOportunidades' => Carbon::now(),
                'clube_id'                  => $clube->id,
                'status'                    => Oportunidade::STATUS_PENDING, 
            ]);

            $oportunidade->posicoes()->sync($validatedData['posicoes_ids']);

            $html = view('clube.partials.opportunity-grid', [
                'oportunidades' => auth()->guard('club')->user()->oportunidades,
                'esportes' => \App\Models\Esporte::all(),
            ])->render();

            return response()->json(['oportunidade' => $oportunidade, 'message' => 'Criado com sucesso!', 'data' => $html], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $oportunidade = Oportunidade::with('esporte', 'posicoes')->find($id);

        if (!$oportunidade) {
            return response()->json([
                'message' => 'Oportunidade não encontrada'
            ], 404);
        }

        if ($oportunidade->clube_id !== Auth::guard('club')->id()) {
            return response()->json([
                'message' => 'Não autorizado'
            ], 403);
        }

        return view('clube.oportunidades.show', compact('oportunidade'));
    }

    public function update(Request $request, $id)
    {
        $oportunidade = Oportunidade::findOrFail($id);
        
        if ($oportunidade->clube_id !== Auth::guard('club')->id()) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $validatedData = $request->validate([
            'tituloOportunidades'    => 'required|string|max:100',
            'descricaoOportunidades' => 'required|string|max:255',
            'esporte_id'             => 'required|exists:esportes,id',
            'posicoes_ids'   => 'required|array|min:1', 
            'posicoes_ids.*' => 'exists:posicoes,id',
            'limite_inscricoes'      => 'required|integer|min:1',
            'idadeMinima'            => 'nullable|integer',
            'idadeMaxima'            => 'nullable|integer',
        ]);

        try {
            $oportunidade->update([
                'tituloOportunidades'    => $validatedData['tituloOportunidades'],
                'descricaoOportunidades' => $validatedData['descricaoOportunidades'],
                'esporte_id'             => $validatedData['esporte_id'],
                'limite_inscricoes'      => $validatedData['limite_inscricoes'],
                'idadeMinima'            => $validatedData['idadeMinima'],
                'idadeMaxima'            => $validatedData['idadeMaxima'],
                'status'                 => Oportunidade::STATUS_PENDING
            ]);

            $oportunidade->posicoes()->sync($validatedData['posicoes_ids']);

            $oportunidade->refresh();

            $html = view('clube.partials.opportunity-grid', [
                'oportunidades' => auth()->guard('club')->user()->oportunidades,
                'esportes' => \App\Models\Esporte::all(),
            ])->render();

            return response()->json(['message' => 'Atualizado com sucesso!', 'data' => $html]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $oportunidade = Oportunidade::findOrFail($id);
        
        if ($oportunidade->clube_id !== Auth::guard('club')->id()) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $oportunidade->delete();
        return response()->json(['message' => 'Excluído com sucesso']);
    }

    public function searchInscricoes(Request $request, $id)
    {
        $oportunidade = Oportunidade::findOrFail($id);

        $search = $request->query('search', '');
        $sortColumn = $request->query('sortColumn', 'created_at');
        $sortDirection = $request->query('sortDirection', 'desc');

        $query = $oportunidade->inscricoes()->with('usuario');

        if ($search) {
            $query->whereHas('usuario', function($q) use ($search) {
                $q->where('nomeCompletoUsuario', 'like', "%{$search}%")
                ->orWhere('emailUsuario', 'like', "%{$search}%")
                ->orWhere('cidadeUsuario', 'like', "%{$search}%");
            });
        }

        if ($sortColumn) {
            if (in_array($sortColumn, ['nomeCompletoUsuario', 'cidadeUsuario', 'dataNascimentoUsuario', 'generoUsuario'])) {
                $query->getQuery()->orders = [];
                $query->join('usuarios', 'inscricoes.usuario_id', '=', 'usuarios.id')
                    ->orderBy(
                        $sortColumn === 'dataNascimentoUsuario' ? 'usuarios.dataNascimentoUsuario' : 'usuarios.'.$sortColumn,
                        $sortDirection
                    );
            } elseif ($sortColumn === 'status') {
                $query->getQuery()->orders = [];
                $query->orderBy('status', $sortDirection);
            }
        }

        $inscricoes = $query->get();

        $html = view('clube.partials.inscricoes-table-body', [
            'inscricoes' => $inscricoes
        ])->render();

        return response()->json(['html' => $html]);
    }
}