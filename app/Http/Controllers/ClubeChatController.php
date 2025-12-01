<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Clube;
use App\Models\Evento;
use App\Models\Conversation;
use Laravel\Sanctum\Sanctum;

class ClubeChatController extends Controller
{
    public function index(Request $request)
    {
        $clube = auth('club')->user();

        if (! $clube instanceof Clube) {
            return redirect()->route('clube.login');
        }

        $eventos = Evento::where('clube_id', $clube->id)
            ->where('data_hora_inicio', '>=', now())
            ->orderBy('data_hora_inicio')
            ->get();

        return view('clube.mensagens', [
            'eventos' => $eventos,
        ]);
    }

    public function conversations(Request $request)
    {
        // garante que está usando o guard do clube (igual no index)
        $clube = auth('club')->user();

        if (! $clube instanceof Clube) {
            return response()->json(['message' => 'Não autenticado.'], 401);
        }

        $conversations = $clube->conversations()
            ->with(['participantOne', 'participantTwo', 'latestMessage'])
            ->get();

        $formatted = $conversations->map(function ($conversation) use ($clube) {
            // descobre quem é o "contato" (o outro lado da conversa)
            if (
                $conversation->participant_one_id == $clube->id &&
                $conversation->participant_one_type == $clube->getMorphClass()
            ) {
                $contact = $conversation->participantTwo;
            } else {
                $contact = $conversation->participantOne;
            }

            if (! $contact) {
                return null;
            }

            // tenta pegar o nome vindo de accessor (name) ou campos conhecidos
            $name = $contact->name
                ?? ($contact->nomeClube ?? null)
                ?? ($contact->nomeCompletoUsuario ?? null)
                ?? ($contact->nome ?? null)
                ?? 'Usuário';

            /**
             * FOTO / AVATAR
             * - Para Usuario: usa accessor "avatar" (getAvatarAttribute) ou fotoPerfilUsuario
             * - Para Clube: tenta "avatar" e "logo"
             * - Se nada existir, usa a imagem padrão: storage/imagens_seeders/usuario_perfil.png
             */
            $avatarPath = $contact->avatar
                ?? $contact->logo
                ?? null;

            if ($avatarPath) {
                $path = ltrim($avatarPath, '/');

                // se já for URL completa, só devolve
                if (Str::startsWith($path, ['http://', 'https://'])) {
                    $avatarUrl = $path;
                } else {
                    // remove "public/" ou "storage/" do começo, se tiver,
                    // para não duplicar no asset('storage/...')
                    $path = preg_replace('#^(public/|storage/)#', '', $path);

                    // monta URL pública via symlink /storage
                    $avatarUrl = asset('storage/' . $path);
                }
            } else {
                // fallback: foto padrão
                $avatarUrl = asset('storage/imagens_seeders/usuario_perfil.png');
            }

            return [
                'conversation_id' => $conversation->id,
                'contact' => [
                    'id'     => $contact->id,
                    'type'   => $contact->getMorphClass(),
                    'name'   => $name,
                    'avatar' => $avatarUrl,
                ],
                'last_message' => $conversation->latestMessage ? [
                    'text' => $conversation->latestMessage->message,
                    'time' => $conversation->latestMessage->created_at->diffForHumans(),
                ] : null,
            ];
        })->filter()->values();

        return response()->json($formatted);
    }

    public function messages(Request $request, $id)
    {
        $clube = $request->user('club');

        if (! $clube instanceof Clube) {
            return response()->json(['message' => 'Não autenticado.'], 401);
        }

        $conversation = Conversation::find($id);

        if (
            ! $conversation ||
            !(
                ($conversation->participant_one_id == $clube->id &&
                    $conversation->participant_one_type == $clube->getMorphClass()) ||
                ($conversation->participant_two_id == $clube->id &&
                    $conversation->participant_two_type == $clube->getMorphClass())
            )
        ) {
            return response()->json(['message' => 'Conversa não encontrada ou acesso negado.'], 404);
        }

        $messages = $conversation->messages()
            ->with(['sender', 'receiver', 'evento', 'conviteEvento'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($m) {
                return [
                    'id'              => $m->id,
                    'conversation_id' => $m->conversation_id,
                    'message'         => $m->message,
                    'type'            => $m->type,
                    'sender_id'       => $m->sender_id,
                    'sender_type'     => $m->sender_type,
                    'receiver_id'     => $m->receiver_id,
                    'receiver_type'   => $m->receiver_type,
                    'is_read'         => $m->is_read,
                    'created_at'      => optional($m->created_at)->toIso8601String(),

                    // usado no front pra saber se é "me" ou não
                    'sender' => [
                        'id'   => $m->sender?->id,
                        'name' => $m->sender?->name,
                        'type' => $m->sender?->getMorphClass(),
                    ],

                    'receiver' => [
                        'id'   => $m->receiver?->id,
                        'name' => $m->receiver?->name,
                        'type' => $m->receiver?->getMorphClass(),
                    ],

                    // aqui vem o que o bubble de convite usa
                    'evento' => $m->evento ? [
                        'id'                => $m->evento->id,
                        'titulo'            => $m->evento->titulo,
                        'data_hora_inicio'  => optional($m->evento->data_hora_inicio)->toIso8601String(),
                        'endereco_formatado'=> $m->evento->endereco_formatado,
                        'cidade'            => $m->evento->cidade,
                    ] : null,

                    'convite_evento' => $m->conviteEvento ? [
                        'id'          => $m->conviteEvento->id,
                        'status'      => $m->conviteEvento->status,
                        'sent_at'     => optional($m->conviteEvento->sent_at)->toIso8601String(),
                        'expires_at'  => optional($m->conviteEvento->expires_at)->toIso8601String(),
                        'responded_at'=> optional($m->conviteEvento->responded_at)->toIso8601String(),
                    ] : null,
                ];
            });

        return response()->json($messages);
    }

    public function sendEventInvite(Request $request)
    {
        $clube = $request->user('club');

        if (! $clube instanceof Clube) {
            return response()->json(['message' => 'Não autenticado.'], 401);
        }

        $data = $request->validate([
            'evento_id'       => 'required|integer|min:1',
            'receiver_id'     => 'required|integer|min:1',
            'receiver_type'   => 'required|string|in:usuario,clube,admin',
            'expiration_type' => 'nullable|string|in:auto,manual',
        ]);

        Sanctum::actingAs(
            $clube,
            ['*'],
            'club_sanctum'
        );

        /** @var \App\Http\Controllers\ChatController $chatController */
        $chatController = app(\App\Http\Controllers\ChatController::class);

        return $chatController->sendEventInvite($request);
    }
}
