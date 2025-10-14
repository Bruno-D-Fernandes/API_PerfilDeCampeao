<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notificavel = auth()->user();

        $perPage = $request->query('per_page', 15);

        return response()->json([
            'todas' => $notificavel->notifications()->paginate($perPage),
            'nao_lidas' => $notificavel->unreadNotifications()->paginate($perPage),
            'quantidade_nao_lidas' => $notificavel->unreadNotifications->count(),
        ]);
    }

    public function marcarComoLida($id)
    {
        $notificavel = auth()->user();

        $notification = $notificavel->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notificação marcada como lida'], 200);
        }

        return response()->json(['message' => 'Notificação não encontrada'], 404);
    }

    public function marcarTodasComoLidas()
    {
        $notificavel = auth()->user();

        $notificavel->unreadNotifications->markAsRead();

        return response()->json(['message' => 'Todas as notificações foram marcadas como lidas'], 200);
    }
}