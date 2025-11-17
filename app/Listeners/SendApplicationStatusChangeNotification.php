<?php

namespace App\Listeners;

use App\Events\ApplicationStatusChangeEvent;
use App\Notifications\ApplicationStatusChangeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendApplicationStatusChangeNotification implements ShouldQueue
{
    public $afterCommit = true;

    public function __construct()
    {
        //
    }

    public function handle(ApplicationStatusChangeEvent $event): void
    {
        $applicant = $event->applicant;
        
        $applicant->notify(new ApplicationStatusChangeNotification(
            $event->applicant, 
            $event->opportunity, 
            $event->club, 
            $event->application, 
            $event->status
        ));
    }
}