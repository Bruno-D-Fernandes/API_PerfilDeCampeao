<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Models\Oportunidade;
use Illuminate\Broadcasting\PrivateChannel;

class OportunidadeAceita extends Notification
{
    use Queueable;

    public Oportunidade $oportunidade;

    public function __construct(Oportunidade $oportunidade)
    {
        $this->oportunidade = $oportunidade;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'oportunidade_aceita',
            'oportunidade_id' => $this->oportunidade->id,
            'titulo' => $this->oportunidade->tituloOportunidades, 
            'clube_id' => $this->oportunidade->clube_id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function broadcastOn()
    {
        return new PrivateChannel('notifications.club.' . $notifiable->id);
    }
}
