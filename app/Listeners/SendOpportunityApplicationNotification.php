<?php

namespace App\Listeners;

use App\Events\OpportunityApplicationCreatedEvent;
use App\Notifications\OpportunityApplicationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOpportunityApplicationNotification implements ShouldQueue
{
    public $afterCommit = true;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OpportunityApplicationCreatedEvent $event): void
    {
        $applicant = $event->applicant;
        $opportunity = $event->opportunity;
        $club = $event->club;
        $club->notify(new OpportunityApplicationNotification($applicant, $opportunity, $club));
    }
}
