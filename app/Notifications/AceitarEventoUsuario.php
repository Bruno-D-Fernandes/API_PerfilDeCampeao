<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\ConviteEvento;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Notifications\Channels\BroadcastChannel;

class AceitarEventoUsuario extends Notification

{
    use Queueable;

    public ConviteEvento $convite;

    public function __construct(ConviteEvento $convite)
    {
        $this->convite = $convite;
    }
    public function via($notifiable)
    {
        return[
            'database',
            'broadcast'
        ];
    }
    public function toArray(object $notifiable): array
    {
        return [
           'type' => 'convite_evento',
           'convite_id' => $this->convite->id,
           'evento_id' => $this->convite->evento->id,
           'usuario_id' => $this->convite->usuario->id,
           'usuario_nome' => $this->convite->usuario->nomeCompletoUsuario,
        ];
    }

    public function toBroadcast($notifiable){
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function broadcastOn($notifiable)
    {
        return new PrivateChannel('notifications.club.' . $notifiable->id);
    }
}
