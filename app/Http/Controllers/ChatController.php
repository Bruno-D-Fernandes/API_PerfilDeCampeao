<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Notifications\MessageReceivedNotification;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Clube;
use App\Models\Admin;
use App\Events\MessageSent;
use App\Models\Usuario;
use App\Models\ConviteEvento;
use App\Models\Evento;
use Exception;


class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        try {
            $validated = $request->validate([
                'receiver_id'   => 'required|integer|min:1',
                'receiver_type' => 'required|string|in:usuario,clube,admin',
                'message'       => 'required|string|max:5000',
            ]);

            $sender = auth('sanctum')->user() ?? auth('club_sanctum')->user() ?? auth('adm_sanctum')->user();

            if (!$sender) {
                return response()->json(['message' => 'Não autenticado.'], 401);
            }

            $receiverId = $validated['receiver_id'];
            $receiverTypeMap = [
                'usuario' => Usuario::class,
                'clube'   => Clube::class,
                'admin'   => Admin::class,
            ];
            $receiverType = $receiverTypeMap[$validated['receiver_type']] ?? null;

            if (!$receiverType || !($receiver = $receiverType::find($receiverId))) {
                return response()->json(['message' => 'Destinatário não encontrado.'], 404);
            }

            if ($sender->id == $receiver->id && $sender->getMorphClass() == $receiver->getMorphClass()) {
                return response()->json(['message' => 'Você não pode enviar uma mensagem para si mesmo.'], 422);
            }

            $conversation = Conversation::where(function ($query) use ($sender, $receiver) {
                $query->where('participant_one_id', $sender->id)
                    ->where('participant_one_type', $sender->getMorphClass())
                    ->where('participant_two_id', $receiver->id)
                    ->where('participant_two_type', $receiver->getMorphClass());
            })->orWhere(function ($query) use ($sender, $receiver) {
                $query->where('participant_one_id', $receiver->id)
                    ->where('participant_one_type', $receiver->getMorphClass())
                    ->where('participant_two_id', $sender->id)
                    ->where('participant_two_type', $sender->getMorphClass());
            })->first();

            if (!$conversation) {
                $conversation = new Conversation;
                $conversation->participantOne()->associate($sender);
                $conversation->participantTwo()->associate($receiver);
                $conversation->save();
            }

            $msg = new Message([
                'message' => $validated['message'],
                // Outros campos do $fillable, como 'type', podem ser adicionados aqui
            ]);

            $msg->conversation()->associate($conversation);
            $msg->sender()->associate($sender);
            $msg->receiver()->associate($receiver);

            $msg->save();

            $msg->receiver->notify(new MessageReceivedNotification($msg));

            broadcast(new MessageSent($msg->load('sender')))->toOthers();

            return response()->json(['status' => 'success', 'data' => $msg], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Dados inválidos.',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Ocorreu um erro interno no servidor.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function sendEventInvite(Request $request)
    {
        try {
            $request->validate([
                'receiver_id' => 'required|exists:usuarios,id',
                'evento_id'   => 'required|exists:eventos,id',
            ]);

            $sender = auth('club_sanctum')->user();
            if (!$sender) {
                return response()->json(['message' => 'Apenas clubes autenticados podem enviar convites.'], 401);
            }
            $senderId = $sender->id;

            $receiverId = (int) $request->receiver_id;
            $receiver = Usuario::findOrFail($receiverId);

            $conversation = Conversation::where(function ($query) use ($sender, $receiver) {
                $query->where('participant_one_id', $sender->id)
                    ->where('participant_one_type', $sender->getMorphClass())
                    ->where('participant_two_id', $receiver->id)
                    ->where('participant_two_type', $receiver->getMorphClass());
            })->orWhere(function ($query) use ($sender, $receiver) {
                $query->where('participant_one_id', $receiver->id)
                    ->where('participant_one_type', $receiver->getMorphClass())
                    ->where('participant_two_id', $sender->id)
                    ->where('participant_two_type', $sender->getMorphClass());
            })->first();

            if (!$conversation) {
                $conversation = new Conversation;
                $conversation->participantOne()->associate($sender);
                $conversation->participantTwo()->associate($receiver);
                $conversation->save();
            }

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
                'conversation_id'   => $conversation->id,
                'sender_id'         => $senderId,
                'sender_type'       => $sender->getMorphClass(),
                'receiver_id'       => $receiverId,
                'receiver_type'     => $receiver->getMorphClass(),
                'message'           => 'Convite para o evento: ' . $evento->titulo,
                'type'              => 'convite',
                'evento_id'         => $evento->id,
                'convite_evento_id' => $convite->id,
            ]);

            $msg->load(['sender', 'receiver', 'evento', 'conviteEvento']);

            broadcast(new MessageSent($msg))->toOthers();

            return response()->json($msg, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Os dados fornecidos são inválidos.',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Recurso não encontrado (usuário ou evento).',
            ], 404);
        } catch (Exception $e) {
            \Log::error("Erro ao enviar convite de evento: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Ocorreu um erro interno no servidor ao processar o convite.',
                'details' => $e->getMessage()
            ], 500);
        }
    }




    public function aceitoInvite(Request $request, $conviteId)
    {
        $convite = ConviteEvento::with('evento.clube')->findOrFail($conviteId);

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

        $convite->evento->clube->notify(new AceitarEventoUsuario($convite));

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
