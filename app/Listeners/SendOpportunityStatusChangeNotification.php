<?php

namespace App\Listeners;

use App\Events\ApplicationStatusChangedEvent;
use App\Notifications\ApplicationStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendApplicationStatusChangeNotification implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(ApplicationStatusChangedEvent $event)
    {
        $applicant = $event->applicant;
        
        $applicant->notify(new ApplicationStatusNotification(
            $event->applicant, 
            $event->opportunity, 
            $event->club, 
            $event->application, 
            $event->status
        ));
    }
}