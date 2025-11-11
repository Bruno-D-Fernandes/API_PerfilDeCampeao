<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue; 
use App\Models\Oportunidade;

class OpportunityStatusChangeNotification extends Notification
{
    use Queueable;

    public $club, $opportunity, $status;

    public function __construct($club, $opportunity, $status)
    {
        $this->club = $club;
        $this->opportunity = $opportunity;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        if ($this->status === Oportunidade::STATUS_APPROVED) {
            $message = "Parabéns! Sua vaga para {$this->opportunity->posicao->nomePosicao} foi APROVADA e está disponível para candidatos.";
        } elseif ($this->status === Oportunidade::STATUS_REJECTED) {
            $message = "Sua vaga para {$this->opportunity->posicao->nomePosicao} foi REJEITADA e requer ajustes. Entre em contato com o suporte.";
        }
        
        return [
            'type' => 'opportunity_status',
            'message' => $message,
            'opportunity_id' => $this->opportunity->id,
            'new_status' => $this->status,
        ];
    }
    
    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}