<?php

namespace App\Http\Controllers;

use App\Events\OpportunityApplicationCreatedEvent;
use Illuminate\Http\Request;
use App\Models\Inscricao;
use App\Models\Oportunidade;
use App\Models\Usuario;
use App\Models\Clube;
use Carbon\Carbon;

class InscricaoOportunidadeController extends Controller
{
    public function store(Request $request, $oportunidadeId)
    {
        $user = $request->user();
        
        if (!$user || !($user instanceof Usuario)) {
            return response()->json(['message' => 'Somente usuário autenticado pode se inscrever'], 403);
        }

        $op = Oportunidade::findOrFail($oportunidadeId);

        $jaExiste = Inscricao::where('oportunidade_id', $op->id)
            ->where('usuario_id', $user->id)->exists();
        if ($jaExiste) {
            return response()->json(['message' => 'Já inscrito'], 409);
        }

        $insc = Inscricao::create([
            'oportunidade_id' => $op->id,
            'usuario_id'      => $user->id,
            'status'          => Inscricao::STATUS_PENDING,
        ]);

        event(new OpportunityApplicationCreatedEvent($user, $op, $op->clube));

        return response()->json($insc, 201);
    }

    // USUÁRIO: minhas inscrições
    public function myOportunidadesUsuario(Request $request)
    {
        $user = $request->user();
        $per_page = $request->query('per_page', 15);
        if (!$user || !($user instanceof Usuario)) {
            return response()->json(['message' => 'Somente usuário autenticado'], 403);
        }

        $lista = Inscricao::with([
                'oportunidade:id,descricaoOportunidades,datapostagemOportunidades,clube_id,posicoes_id,esporte_id',
                'oportunidade.esporte:id,nomeEsporte',
                'oportunidade.posicao:id,nomePosicao',
                'oportunidade.clube:id,nomeClube'
            ])
            ->where('usuario_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate($per_page);

            $lista->setCollection(
                $lista->getCollection()->map(function ($row) {
                    $opp = $row->oportunidade;
                    return [
                        'inscricao_id'   => $row->id,
                        'status'         => $row->status,         
                        'reviewed_at'    => $row->reviewed_at,      
                        'oportunidade'   => [
                            'id'         => $opp?->id,
                            'descricao'  => $opp?->descricaoOportunidades,
                            'data'       => $opp?->datapostagemOportunidades,
                            'modalidade' => $opp?->esporte?->nomeEsporte,
                            'posicao'    => $opp?->posicao?->nomePosicao,
                            'clube'      => $opp?->clube?->nomeClube,
                        ],
                        'inscrito_em'    => $row->created_at,
                    ];
                })
            );

            return response()->json($lista, 200);
    }

    public function cancelar(Request $request, $oportunidadeId)
    {
        $user = $request->user();
        if (!$user || !($user instanceof Usuario)) {
            return response()->json(['message' => 'Somente usuário autenticado'], 403);
        }

        $insc = Inscricao::where('oportunidade_id', $oportunidadeId)
                ->where('usuario_id', $user->id)->firstOrFail();

        $insc->delete();
        return response()->json(['ok' => true]);
    }

    
}


