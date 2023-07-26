<?php

namespace App\Providers;

use App\Events\JobsPosted;
use Event;
use App\Listeners\HandleDeepLink;
use App\Listeners\HandleNotificationClicked;
use App\Listeners\SendNewJobsNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Native\Laravel\Events\App\OpenedFromURL;
use Native\Laravel\Events\Notifications\NotificationClicked;

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
        OpenedFromURL::class => [
            HandleDeepLink::class,
        ],
        NotificationClicked::class => [
            HandleNotificationClicked::class,
        ],
        JobsPosted::class => [
            SendNewJobsNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Handle specific notifications being clicked.
        // Waiting for string events and custom events to be supported
        // Event::listen('notification.clicked.*', function () {
        //     // ray(func_get_args());
        // });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
