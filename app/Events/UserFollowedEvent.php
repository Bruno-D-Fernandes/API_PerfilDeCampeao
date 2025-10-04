<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserFollowedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $follower, $userFollowed, $message;

    /**
     * Create a new event instance.
     */
    public function __construct($follower, $userFollowed)
    {
        $this->follower = $follower;
        $this->userFollowed = $userFollowed;
        $this->message = "O usuário {$follower->nomeCompletoUsuario} começou a seguir você!";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('user_followed_channel'),
        ];
    }
}
