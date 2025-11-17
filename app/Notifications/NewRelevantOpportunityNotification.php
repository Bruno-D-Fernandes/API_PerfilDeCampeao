<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue; 

class NewRelevantOpportunityNotification extends Notification
{
    use Queueable;

    public $opportunity, $applicant;

    public function __construct($opportunity, $applicant)
    {
        $this->opportunity = $opportunity;
        $this->applicant = $applicant;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {     
        $message = "Nova vaga de {$this->opportunity->posicao->nomePosicao} no clube {$this->opportunity->club->nomeClube} que corresponde ao seu perfil de ${$this->opportunity->esporte->nomeEsporte}!";

        return [
            'type' => 'new_relevant_opportunity',
            'message' => $message,
            'opportunity_id' => $this->opportunity->id,
            'club_id' => $this->opportunity->club->id,
        ];
    }
    
    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}