<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado.'], 401);
        }

        $conversations = $user->conversations()
            ->with(['participantOne', 'participantTwo', 'latestMessage'])
            ->get();

        $formattedConversations = $conversations->map(function ($conversation) use ($user) {
            if (
                $conversation->participant_one_id == $user->id &&
                $conversation->participant_one_type == $user->getMorphClass()
            ) {
                $contact = $conversation->participantTwo;
            } else {
                $contact = $conversation->participantOne;
            }



            if (!$contact) {
                return null;
            }

            return [
                'conversation_id' => $conversation->id,
                'contact' => [
                    'id' => $contact->id,
                    'type' => $contact->getMorphClass(),
                    'name' => $contact->name,
                    'avatar' => $contact->avatar,
                ],
                'last_message' => $conversation->latestMessage ? [
                    'text' => $conversation->latestMessage->message,
                    'time' => $conversation->latestMessage->created_at->diffForHumans(),
                ] : null,
            ];
        })->filter()->values();

        return response()->json($formattedConversations);
    }

    public function getMessages(Request $request, $id)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado.'], 401);
        }

        $conversation = Conversation::find($id);

        if (
            !$conversation ||
            !(
                ($conversation->participant_one_id == $user->id &&
                    $conversation->participant_one_type == $user->getMorphClass()) ||
                ($conversation->participant_two_id == $user->id &&
                    $conversation->participant_two_type == $user->getMorphClass())
            )
        ) {
            return response()->json(['message' => 'Conversa não encontrada ou acesso negado.'], 404);
        }

        $messages = $conversation->messages()->with('evento', 'conviteEvento')->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }
}
