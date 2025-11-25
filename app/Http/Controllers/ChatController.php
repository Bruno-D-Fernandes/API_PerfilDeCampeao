<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Usuario;
use App\Models\Clube;
use App\Models\Admin;
use App\Events\MessageSent;

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
}
