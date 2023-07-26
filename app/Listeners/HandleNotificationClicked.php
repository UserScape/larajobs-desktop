<?php

namespace App\Listeners;

use Native\Laravel\Events\Notifications\NotificationClicked;
use Native\Laravel\Facades\MenuBar;

class HandleNotificationClicked
{
    /**
     * Handle the event.
     */
    public function handle(NotificationClicked $event): void
    {
        // @TODO: Waiting on PRs to NativePHP repos to be merged in order to
        // directly open the URL in the browser from the notification.
        // @see https://github.com/NativePHP/laravel/pull/67
        // @see https://github.com/NativePHP/electron-plugin/pull/4
        MenuBar::show();
    }
}