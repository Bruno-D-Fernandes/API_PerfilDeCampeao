<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;

class OpportunityApplicationNotification extends Notification
{
    use Queueable;

    public $applicant, $opportunity, $club;

    /**
     * Create a new notification instance.
     */
    public function __construct($applicant, $opportunity, $club)
    {
        $this->applicant = $applicant;
        $this->opportunity = $opportunity;
        $this->club = $club;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'opportunity_application',
            'message' => "{$this->applicant->nomeCompletoUsuario} se inscreveu em sua oportunidade de recrutamento!",
            'user_id' => $this->applicant->id,
            'user_name' => $this->applicant->nomeCompletoUsuario,
        ];
    }

    public function toDatabase($notifiable)
    {
        return $this->toArray($notifiable);
    }
}