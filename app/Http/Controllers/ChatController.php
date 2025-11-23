<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use App\Models\Usuario;
use App\Models\ConviteEvento;
use App\Models\Evento;
use App\Models\Clube;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:usuarios,id',
            'message'     => 'required|string',
        ]);

        $msg = Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
            'type'        => 'text',
        ]);

        $msg->load(['sender', 'receiver']);

        broadcast(new MessageSent($msg))->toOthers();

        return response()->json($msg);
    }

    public function sendEventInvite(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:usuarios,id',
            'evento_id'   => 'required|exists:eventos,id',
        ]);

        $senderId   = auth()->id();
        $receiverId = (int) $request->receiver_id;

        $evento = Evento::findOrFail($request->evento_id);

        if ($evento->clube_id !== $senderId) {
            return response()->json([
                'message' => 'Apenas o clube dono do evento pode enviar convites.',
            ], 403);
        }

        $existingConvite = ConviteEvento::where('evento_id', $evento->id)
            ->where('usuario_id', $receiverId)
            ->first();

        if ($existingConvite) {
            return response()->json([
                'message' => 'Já existe um convite para este usuário neste evento.',
            ], 422);
        }

        $convite = ConviteEvento::create([
            'evento_id'   => $evento->id,
            'usuario_id'  => $receiverId,
            'status'      => ConviteEvento::STATUS_PENDENTE,
            'sent_at'     => now(),
            'expires_at'  => $evento->data_hora_inicio,
        ]);

        $msg = Message::create([
            'sender_id'         => $senderId,
            'receiver_id'       => $receiverId,
            'message'           => 'Convite para o evento: ' . $evento->titulo,
            'type'              => 'convite',
            'evento_id'         => $evento->id,
            'convite_evento_id' => $convite->id,
        ]);

        $msg->load(['sender', 'receiver', 'evento', 'conviteEvento']);

        broadcast(new MessageSent($msg))->toOthers();

        return response()->json($msg);
    }

   public function aceitoInvite(Request $request, $conviteId)
{
    $convite = ConviteEvento::with('evento')->findOrFail($conviteId);

    $user = $request->user();
    if (!$user instanceof Usuario) {
        return response()->json(['message' => 'Usuário não encontrado'], 404);
    }

    if ($convite->usuario_id !== $user->id) {
        return response()->json(['message' => 'Apenas o usuário convidado pode aceitar o convite.'], 403);
    }

    if ($convite->status !== ConviteEvento::STATUS_PENDENTE) {
        return response()->json(['message' => 'O convite já foi respondido.'], 422);
    }

    if ($convite->isExpired()) {
        $convite->status = ConviteEvento::STATUS_EXPIRADO;
        $convite->save();

        return response()->json(['message' => 'O convite já expirou.'], 422);
    }

    $evento = $convite->evento;

    if ($evento && $evento->limite_participantes) {
        $totalAceitos = $evento->convites()
            ->ativos()
            ->count();

        if ($totalAceitos >= $evento->limite_participantes) {
            return response()->json([
                'message' => 'O limite de participantes deste evento já foi atingido.',
            ], 422);
        }
    }

   
    $convite->status       = ConviteEvento::STATUS_ACEITO;
    $convite->responded_at = now();
    $convite->save();

    return response()->json([
        'message' => 'Convite aceito com sucesso.',
        'convite' => $convite,
    ]);
}

    public function clubeCancelInvite(Request $request, $conviteId)
    {
        $convite = ConviteEvento::findOrFail($conviteId);

        $clube = $request->user();

        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        if ($convite->evento->clube_id !== $clube->id) {
            return response()->json(['message' => 'Apenas o clube dono do evento pode cancelar o convite.'], 403);
        }

        if ($convite->status === ConviteEvento::STATUS_CANCELADO_PELO_CLUBE) {
            return response()->json(['message' => 'O convite já foi cancelado.'], 422);
        }

        $convite->status       = ConviteEvento::STATUS_CANCELADO_PELO_CLUBE;
        $convite->responded_at = now();
        $convite->save();

        return response()->json([
            'message' => 'Convite cancelado com sucesso pelo clube.',
            'convite' => $convite,
        ]);
    }

    
}
