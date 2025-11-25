<?php

namespace App\Http\Controllers;

use App\Events\ApplicationStatusChangeEvent;
use App\Events\OpportunityApplicationCreatedEvent;
use Illuminate\Http\Request;
use App\Models\Inscricao;
use App\Models\Oportunidade;
use App\Models\Usuario;
use App\Models\Clube;
use Carbon\Carbon;

class InscricaoOportunidadeController extends Controller
{
    /**
     * USUÁRIO: inscrever-se em uma oportunidade (status = PENDING).
     */
 public function store(Request $request, $oportunidadeId)
{
    $user = $request->user();

    if (!$user || !($user instanceof Usuario)) {
        return response()->json(['message' => 'Somente usuário autenticado pode se inscrever'], 403);
    }

    $op = Oportunidade::findOrFail($oportunidadeId);

    if (!is_null($op->limite_inscricoes)) {
        $totalInscritos = $op->inscricoes()
            ->whereIn('status', [Inscricao::STATUS_PENDING, Inscricao::STATUS_APPROVED])
            ->count();

        if ($totalInscritos >= $op->limite_inscricoes) {
            return response()->json(['message' => 'Esta oportunidade já atingiu o limite de inscrições.'], 422);
        }
    }

    $jaExiste = Inscricao::where('oportunidade_id', $op->id)
        ->where('usuario_id', $user->id)
        ->exists();

    if ($jaExiste) {
        return response()->json(['message' => 'Você já está inscrito nesta oportunidade.'], 409);
    }

    if (!is_null($op->alturaMinCm) || !is_null($op->alturaMaxCm)) {
        if (is_null($user->alturaCm)) {
            return response()->json(['message' => 'Preencha sua altura (cm) no perfil para se inscrever nesta oportunidade.'], 422);
        }

        if (!is_null($op->alturaMinCm) && $user->alturaCm < $op->alturaMinCm) {
            return response()->json(['message' => 'Altura abaixo do mínimo exigido.'], 422);
        }

        if (!is_null($op->alturaMaxCm) && $user->alturaCm > $op->alturaMaxCm) {
            return response()->json(['message' => 'Altura acima do máximo exigido.'], 422);
        }
    }

    if (!is_null($op->pesoMinKg) || !is_null($op->pesoMaxKg)) {
        if (is_null($user->pesoKg)) {
            return response()->json(['message' => 'Preencha seu peso (kg) no perfil para se inscrever nesta oportunidade.'], 422);
        }

        if (!is_null($op->pesoMinKg) && $user->pesoKg < $op->pesoMinKg) {
            return response()->json(['message' => 'Peso abaixo do mínimo exigido.'], 422);
        }

        if (!is_null($op->pesoMaxKg) && $user->pesoKg > $op->pesoMaxKg) {
            return response()->json(['message' => 'Peso acima do máximo exigido.'], 422);
        }
    }

    $insc = Inscricao::create([
        'oportunidade_id' => $op->id,
        'usuario_id'      => $user->id,
        'status'          => Inscricao::STATUS_PENDING,
    ]);

    event(new OpportunityApplicationCreatedEvent($user, $op, $op->clube));

    return response()->json($insc, 201);
}




    /**
     * USUÁRIO: minhas inscrições (com paginação configurável).
     */
    public function myOportunidadesUsuario(Request $request)
    {
        $user = $request->user();
        $per_page = (int) $request->query('per_page', 15);

        if (!$user || !($user instanceof Usuario)) {
            return response()->json(['message' => 'Somente usuário autenticado'], 403);
        }

        $lista = Inscricao::with([
            'oportunidade:id,descricaoOportunidades,datapostagemOportunidades,clube_id,posicoes_id,esporte_id,idadeMinima,idadeMaxima,status',
            'oportunidade.esporte:id,nomeEsporte',
            'oportunidade.posicao:id,nomePosicao',
            'oportunidade.clube'
        ])
            ->where('usuario_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate($per_page);

        return response()->json($lista);
    }

    /**
     * 
     */
    public function inscritosClube(Request $request, $oportunidadeId)
    {
        $clube = $request->user();
        if (!$clube || !($clube instanceof Clube)) {
            return response()->json(['message' => 'Somente clube autenticado'], 403);
        }

        $op = Oportunidade::findOrFail($oportunidadeId);
        if ((int)$op->clube_id !== (int)$clube->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $perPage = (int) $request->query('per_page', 15);

        $listAtletas = Inscricao::with([
            'usuario:id,nomeCompletoUsuario,emailUsuario,estadoUsuario,cidadeUsuario,dataNascimentoUsuario,alturaCm,pesoKg'
        ])
            ->where('oportunidade_id', $oportunidadeId)
            ->where(function ($q) {
                $q->where('status', Inscricao::STATUS_PENDING)
                    ->orWhere('status', Inscricao::STATUS_APPROVED);
            })
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return response()->json($listAtletas, 200);
    }

    /**
     * 
     */
    public function aceitar(Request $request, $oportunidadeId, $usuarioId)
    {
        $clube = $request->user();
        if (!$clube || !($clube instanceof Clube)) {
            return response()->json(['message' => 'Somente clube autenticado'], 403);
        }

        $op = Oportunidade::findOrFail($oportunidadeId);
        if ((int)$op->clube_id !== (int)$clube->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $usuario = Usuario::findOrFail($usuarioId);

        $insc = Inscricao::where('oportunidade_id', $op->id)
            ->where('usuario_id', $usuario->id)
            ->firstOrFail();

        if ($insc->status !== Inscricao::STATUS_APPROVED) {
            $insc->update(['status' => Inscricao::STATUS_APPROVED]);
        }

        $tipo = Inscricao::STATUS_APPROVED;

        event(new ApplicationStatusChangeEvent($usuario, $op, $clube, $insc, $tipo));

        return response()->json([
            'status' => $insc->status,
            'message' => 'Inscrição aprovada com sucesso.'
        ], 200);
    }

    /**
     * 
     */
    public function remover(Request $request, $oportunidadeId, $usuarioId)
    {
        $clube = $request->user();
        if (!$clube || !($clube instanceof Clube)) {
            return response()->json(['message' => 'Somente clube autenticado'], 403);
        }

        $op = Oportunidade::findOrFail($oportunidadeId);
        if ((int)$op->clube_id !== (int)$clube->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $usuario = Usuario::findOrFail($usuarioId);

        $insc = Inscricao::where('oportunidade_id', $op->id)
            ->where('usuario_id', $usuarioId)->firstOrFail();


        if ($insc->status !== Inscricao::STATUS_REJECTED) {
            $insc->update(['status' => Inscricao::STATUS_REJECTED]);
        }

        $tipo = Inscricao::STATUS_REJECTED;

        event(new ApplicationStatusChangeEvent($usuario, $op, $clube, $insc, $tipo));

        return response()->json([
            'status' => $insc->status,
            'message' => 'Inscrição recusada com sucesso.'
        ], 200);
    }

    /**
     * USUÁRIO: cancelar a própria inscrição (deleta).
     */
    public function cancelar(Request $request, $oportunidadeId)
    {
        $user = $request->user();
        if (!$user || !($user instanceof Usuario)) {
            return response()->json(['message' => 'Somente usuário autenticado'], 403);
        }

        $insc = Inscricao::where('oportunidade_id', $oportunidadeId)
            ->where('usuario_id', $user->id)
            ->firstOrFail();

        $insc->delete();
        return response()->json([
            'message' => 'Inscrição cancelada com sucesso.'
        ], 200);
    }

    /**
     * 
     */
    public function myOportunidadesClube(Request $request)
    {
        $clube = $request->user();
        $per_page = (int) $request->query('per_page', 15);

        if (!$clube || !($clube instanceof Clube)) {
            return response()->json(['message' => 'Somente clube autenticado'], 403);
        }

        $q = Oportunidade::where('clube_id', $clube->id)
            ->with(['esporte', 'posicao'])
            ->orderByDesc('id');

        if ($s = $request->query('status')) {
            $q->where('status', $s);
        }

        return response()->json($q->paginate($per_page));
    }
}
