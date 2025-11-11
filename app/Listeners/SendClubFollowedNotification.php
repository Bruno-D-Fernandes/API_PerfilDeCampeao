<?php

namespace App\Listeners;

use App\Events\ClubFollowedEvent;
use App\Notifications\ClubFollowedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendClubFollowedNotification implements ShouldQueue
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
    public function handle(ClubFollowedEvent $event): void
    {
        $club = $event->club;
        $follower = $event->follower;
        $club->notify(new ClubFollowedNotification($follower, $club));
    }
}
