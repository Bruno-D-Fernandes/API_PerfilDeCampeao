<?php

namespace App\Listeners;

use App\Events\ClubFollowedEvent;
use App\Notifications\ClubFollowedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendClubFollowedNotification
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
        $clubFollowed = $event->clubFollowed;
        $follower = $event->follower;
        $clubFollowed->notify(new ClubFollowedNotification($follower, $clubFollowed));
    }
}
