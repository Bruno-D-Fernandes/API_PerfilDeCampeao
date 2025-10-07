<?php

// app/Http/Controllers/InscricaoOportunidadeController.php
namespace App\Http\Controllers;

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
            'status'          => 'pendente',
        ]);

        return response()->json($insc, 201);
    }

    // USUÁRIO: minhas inscrições
    public function minhas(Request $request)
    {
        $user = $request->user();
        if (!$user || !($user instanceof Usuario)) {
            return response()->json(['message' => 'Somente usuário autenticado'], 403);
        }

        $lista = Inscricao::with([
                'oportunidade:id,descricaoOportunidades,datapostagemOportunidades,clube_id,posicoes_id,esporte_id',
                'oportunidade.esporte:id,nomeEsporte',
                'oportunidade.posicao:id,nomePosicao',
            ])
            ->where('usuario_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(15);

        return response()->json($lista);
    }

    // CLUBE: ver inscritos de uma oportunidade do próprio clube
    public function inscritosClube(Request $request, $oportunidadeId)
    {
        $clube = $request->user();
        if (!$clube || !($clube instanceof Clube)) {
            return response()->json(['message' => 'Somente clube autenticado'], 403);
        }

        $op = Oportunidade::with(['esporte:id,nomeEsporte','posicao:id,nomePosicao'])->findOrFail($oportunidadeId);
        if ($op->clube_id !== $clube->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $inscritos = Inscricao::with([
                'usuario:id,nomeCompletoUsuario,emailUsuario,estadoUsuario,cidadeUsuario,dataNascimentoUsuario,alturaCm,pesoKg'
            ])
            ->where('oportunidade_id', $op->id)
            ->orderByDesc('created_at')
            ->paginate(30);

        // Formata saída estilo do seu print (nome, modalidade-posicao, cidade/estado, idade)
        $mapped = $inscritos->getCollection()->map(function($row) use ($op) {
            $u = $row->usuario;
            return [
                'inscricao_id' => $row->id,
                'usuario_id'   => $u->id,
                'nome'         => $u->nomeCompletoUsuario,
                'modalidade'   => $op->esporte?->nomeEsporte,
                'posicao'      => $op->posicao?->nomePosicao,
                'local'        => ($u->cidadeUsuario ? $u->cidadeUsuario.' - ' : '') . ($u->estadoUsuario ?? ''),
                'idade'        => $u->dataNascimentoUsuario ? Carbon::parse($u->dataNascimentoUsuario)->age . ' anos' : null,
                'status'       => $row->status,
                // se quiser, adicione link pro perfil
                // 'perfil_url' => route('usuario.show', $u->id) // se existir
            ];
        });

        $inscritos->setCollection($mapped);
        return response()->json($inscritos);
    }

    // CLUBE: remover um inscrito (ex.: botão "Remover")
    public function remover(Request $request, $oportunidadeId, $usuarioId)
    {
        $clube = $request->user();
        if (!$clube || !($clube instanceof Clube)) {
            return response()->json(['message' => 'Somente clube autenticado'], 403);
        }

        $op = Oportunidade::findOrFail($oportunidadeId);
        if ($op->clube_id !== $clube->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $insc = Inscricao::where('oportunidade_id', $op->id)
                ->where('usuario_id', $usuarioId)->firstOrFail();

        $insc->delete();
        return response()->json(['ok' => true]);
    }

    // USUÁRIO: cancelar a própria inscrição (opcional)
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


