<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusChangeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $applicant, $opportunity, $club, $application, $status;

    public function __construct($applicant, $opportunity, $club, $application, $status)
    {
        $this->applicant = $applicant;
        $this->opportunity = $opportunity;
        $this->club = $club;
        $this->application = $application;
        $this->status = $status;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications.user.' . $this->applicant->id),
        ];
    }

    public function broadcastAs()
    {
        return 'application.status.changed';
    }
}