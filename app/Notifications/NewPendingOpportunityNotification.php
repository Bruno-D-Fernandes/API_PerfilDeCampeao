<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue; 

class NewPendingOpportunityNotification extends Notification
{
    use Queueable;

    public $opportunity, $club;

    public function __construct($opportunity, $club)
    {
        $this->opportunity = $opportunity;
        $this->club = $club;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        $message = "Nova oportunidade PENDENTE {$this->opportunity->posicao->nomePosicao} por {$this->club->nomeClube}.";

        return [
            'type' => 'new_pending_opportunity',
            'message' => $message,
            'opportunity_id' => $this->opportunity->id,
            'club_id' => $this->club->id,
        ];
    }
    
    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}