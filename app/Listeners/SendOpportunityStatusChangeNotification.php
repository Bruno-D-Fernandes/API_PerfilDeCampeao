<?php

namespace App\Listeners;

use App\Events\OpportunityStatusChangeEvent;
use App\Notifications\OpportunityStatusChangeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOpportunityStatusChangeNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public $afterCommit = true;

    public function __construct()
    {
        //
    }

    public function handle(OpportunityStatusChangeEvent $event): void
    {
        $club = $event->club;
        
        $club->notify(new OpportunityStatusChangeNotification(
            $event->club, 
            $event->opportunity, 
            $event->status
        ));
    }
}