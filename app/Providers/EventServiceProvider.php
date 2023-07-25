<?php

namespace App\Providers;

use App\Events\ClickedJob;
use App\Listeners\MenuBarOpenedListener;
use App\Listeners\OpenMenuBar;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Native\Laravel\Events\MenuBar\MenuBarShown;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        MenuBarShown::class => [
            MenuBarOpenedListener::class
        ],
        ClickedJob::class => [
            OpenMenuBar::class,
        ],
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
