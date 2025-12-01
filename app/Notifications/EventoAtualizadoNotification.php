<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Evento;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class EventoAtualizadoNotification extends Notification
{
    use Queueable;

    public Evento $evento;

    public function __construct(Evento $evento)
    {
        $this->evento = $evento;
    }

    public function via($notifiable)
    {
        return [
            'database',
            'broadcast'
    ];
    }
    public function toArray($notifiable)
    {
        return [
            'type' => 'evento_atualizado',
            'evento_id' =>$this->evento->id,
            'titulo' => $this->evento->titulo,
            'clube_id' => $this->evento->clube_id,
        ];
    }

    public function toBroadcast($notifiable){
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function broadcastOn($notifiable){
        return new PrivateChannel('notification.user.' . $notifiable->id);
    }
}
