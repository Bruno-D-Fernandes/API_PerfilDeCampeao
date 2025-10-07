<?php

namespace App\Listeners;

use App\Events\UserFollowedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\UserFollowedNotification;

class SendUserFollowedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(UserFollowedEvent $event): void
    {
        $userFollowed = $event->userFollowed;
        $follower = $event->follower;
        $userFollowed->notify(new UserFollowedNotification($follower, $userFollowed));
    }
}
