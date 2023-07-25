<?php

namespace App\Listeners;

use Native\Laravel\Client\Client;
use Native\Laravel\Events\Notifications\NotificationClicked;
use Native\Laravel\Facades\Window;
// use Native\Laravel\Notification;

use Illuminate\Support\Str;
use Native\Laravel\Facades\MenuBar;

class HandleNotificationClicked
{
    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        // @TODO: Waiting on PRs to NativePHP repos to be merged in order to
        // directly open the URL in the browser from the notification.
        // @see https://github.com/NativePHP/laravel/pull/67
        // @see https://github.com/NativePHP/electron-plugin/pull/4
        MenuBar::show();
    }
}