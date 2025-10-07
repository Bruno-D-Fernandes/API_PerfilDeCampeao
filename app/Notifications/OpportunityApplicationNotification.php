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

    public $userApplier, $opportunityApplied, $clubApplied;

    /**
     * Create a new notification instance.
     */
    public function __construct($userApplier, $opportunityApplied, $clubApplied)
    {
        $this->userApplier = $userApplier;
        $this->opportunityApplied = $opportunityApplied;
        $this->clubApplied = $clubApplied;
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
            'message' => "{$this->userApplier->nomeCompletoUsuario} se inscreveu na oportunidade!",
            'user_id' => $this->userApplier->id,
            'user_name' => $this->userApplier->nomeCompletoUsuario,
        ];
    }

    public function toDatabase($notifiable)
    {
        return $this->toArray($notifiable);
    }
}