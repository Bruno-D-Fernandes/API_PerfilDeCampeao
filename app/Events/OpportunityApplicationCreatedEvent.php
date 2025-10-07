<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OpportunityApplicationCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userApplier, $opportunityApplied, $clubApplied;

    /**
     * Create a new event instance.
     */
    public function __construct($userApplier, $opportunityApplied, $clubApplied)
    {
        $this->userApplier = $userApplier;
        $this->opportunityApplied = $opportunityApplied;
        $this->clubApplied = $clubApplied;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications.club.' . $this->clubApplied->id),
        ];
    }

    public function broadcastAs()
    {
        return 'opportunity.applied';
    }
}