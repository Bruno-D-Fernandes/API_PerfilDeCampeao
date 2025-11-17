<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewPendingOpportunityEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $opportunity, $club;

    public function __construct($opportunity, $club)
    {
        $this->opportunity = $opportunity;
        $this->club = $club;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications.admin'),
        ];
    }

    public function broadcastAs()
    {
        return 'opportunity.new.pending';
    }
}