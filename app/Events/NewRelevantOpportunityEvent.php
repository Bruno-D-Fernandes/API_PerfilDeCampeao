<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewRelevantOpportunityEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $opportunity, $applicant;

    public function __construct($opportunity, $applicant)
    {
        $this->opportunity = $opportunity;
        $this->applicant = $applicant;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications.user.' . $this->applicant->id),
        ];
    }

    public function broadcastAs()
    {
        return 'opportunity.new.relevant';
    }
}