<?php

namespace App\Listeners;

use App\Events\NewPendingOpportunityEvent;
use App\Notifications\NewPendingOpportunityNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewPendingOpportunityNotification implements ShouldQueue
{
    use InteractsWithQueue, ShouldQueue;

    public function handle(NewPendingOpportunityEvent $event): void
    {
        $admins = Admin::all();
        
        Notification::send($admins, new NewPendingOpportunityNotification(
            $event->opportunity,
            $event->club
        ));
    }
}