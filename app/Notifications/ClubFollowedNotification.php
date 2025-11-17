<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClubFollowedNotification extends Notification
{
    use Queueable;

    public $follower, $clubFollowed;

    /**
     * Create a new notification instance.
     */
    public function __construct($follower, $clubFollowed)
    {
        $this->follower = $follower;
        $this->clubFollowed = $clubFollowed;
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
            'type' => 'club_followed',
            'message' => "{$this->follower->nomeCompletoUsuario} comecou a seguir voce!",
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->nomeCompletoUsuario,
        ];
    }

    public function toDatabase($notifiable)
    {
        return $this->toArray($notifiable);
    }
}