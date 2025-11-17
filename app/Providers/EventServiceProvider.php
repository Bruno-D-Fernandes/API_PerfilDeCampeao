<?php

namespace App\Providers;

use App\Events\ApplicationStatusChangeEvent;
use App\Events\ClubFollowedEvent;
use App\Events\NewPendingOpportunityEvent;
use App\Events\NewRelevantOpportunityEvent;
use App\Events\OpportunityApplicationCreatedEvent;
use App\Events\OpportunityStatusChangeEvent;
use App\Events\UserFollowedEvent;
use App\Listeners\SendApplicationStatusChangeNotification;
use App\Listeners\SendClubFollowedNotification;
use App\Listeners\SendNewPendingOpportunityNotification;
use App\Listeners\SendNewRelevantOpportunityNotification;
use App\Listeners\SendOpportunityApplicationNotification;
use App\Listeners\SendUserFollowedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\SendOpportunityStatusChangeNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserFollowedEvent::class => [
            SendUserFollowedNotification::class,
        ],
        ClubFollowedEvent::class => [
            SendClubFollowedNotification::class,
        ],
        OpportunityApplicationCreatedEvent::class => [
            SendOpportunityApplicationNotification::class,
        ],
        OpportunityStatusChangeEvent::class => [
            SendOpportunityStatusChangeNotification::class,
        ],
        ApplicationStatusChangeEvent::class => [
            SendApplicationStatusChangeNotification::class,
        ],
        NewPendingOpportunityEvent::class => [
            SendNewPendingOpportunityNotification::class,
        ],
        NewRelevantOpportunityEvent::class => [
            SendNewRelevantOpportunityNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
