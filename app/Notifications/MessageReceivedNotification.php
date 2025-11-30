<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;

class MessageReceivedNotification extends Notification
{
    use Queueable;

    public Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'message_received',
            'message_id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'sender_id' => $this->message->sender_id,
            'text' => $this->message->message,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function broadcastOn()
    {
        if ($this->message->receiver_type === 'usuario') {
            return new PrivateChannel('notifications.user.' . $this->message->receiver_id);
        }

        if ($this->message->receiver_type === 'clube') {
            return new PrivateChannel('notifications.club.' . $this->message->receiver_id);
        }

        return [];
    }
}
