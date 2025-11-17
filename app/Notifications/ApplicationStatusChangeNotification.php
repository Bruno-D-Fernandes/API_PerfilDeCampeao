<?php

namespace App\Notifications;

use App\Models\Inscricao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ApplicationStatusChangeNotification extends Notification
{
    use Queueable;

    public $applicant, $opportunity, $club, $application, $status;

    public function __construct($applicant, $opportunity, $club, $application, $status)
    {
        $this->applicant = $applicant;
        $this->opportunity = $opportunity;
        $this->club = $club;
        $this->application = $application;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        $message = "O status da sua inscrição para a vaga '{$this->opportunity->name}' foi atualizado.";
        
        if ($this->status === Inscricao::STATUS_APPROVED) {
            $message = "Parabéns! Sua candidatura para a vaga de {$this->opportunity->posicao->nomePosicao} no {$this->club->nomeClube} foi ACEITA!";
        } elseif ($this->status === Inscricao::STATUS_REJECTED) {
            $message = "Sua candidatura para a vaga de {$this->opportunity->posicao->nomePosicao} no {$this->club->nomeClube} foi REJEITADA.";
        }

        return [
            'type' => 'application_status',
            'message' => $message,
            'opportunity_id' => $this->opportunity->id,
            'club_id' => $this->club->id,
            'new_status' => $this->status,
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}