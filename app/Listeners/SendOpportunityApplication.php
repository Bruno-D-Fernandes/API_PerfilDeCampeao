<?php

namespace App\Listeners;

use App\Events\OpportunityApplicationCreatedEvent;
use App\Notifications\OpportunityApplicationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOpportunityApplication
{
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
        $userApplier = $event->userApplier;
        $opportunityApplied = $event->opportunityApplied;
        $clubApplied = $event->clubApplied;
        $clubApplied->notify(new OpportunityApplicationNotification($userApplier, $opportunityApplied, $clubApplied));
    }
}
