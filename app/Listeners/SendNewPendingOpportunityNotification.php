<?php

namespace App\Listeners;

use App\Models\Admin;
use App\Events\NewPendingOpportunityEvent;
use App\Notifications\NewPendingOpportunityNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewPendingOpportunityNotification implements ShouldQueue
{
    public $afterCommit = true;

    public function handle(NewPendingOpportunityEvent $event): void
    {
        $admins = Admin::all();
        
        Notification::send($admins, new NewPendingOpportunityNotification(
            $event->opportunity,
            $event->club
        ));
    }
}