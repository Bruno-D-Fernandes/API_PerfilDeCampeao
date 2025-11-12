<?php

namespace App\Listeners;

use App\Events\NewRelevantOpportunityEvent;
use App\Notifications\NewRelevantOpportunityNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewRelevantOpportunityNotification
{
    public $afterCommit = true;

    public function __construct()
    {
        //
    }

    public function handle(NewRelevantOpportunityEvent $event): void
    {
        $applicant = $event->applicant;
        $opportunity = $event->opportunity;
        
        $applicant->notify(new NewRelevantOpportunityNotification(
            $opportunity,
            $applicant
        ));
    }
}