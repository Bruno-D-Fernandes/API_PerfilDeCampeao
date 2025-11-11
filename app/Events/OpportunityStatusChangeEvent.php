<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OpportunityStatusChangeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $club, $opportunity, $status;

    public function __construct($club, $opportunity, $status)
    {
        $this->club = $club;
        $this->opportunity = $opportunity;
        $this->status = $status;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications.club.' . $this->club->id),
        ];
    }

    public function broadcastAs()
    {
        return 'opportunity.status.changed';
    }
}