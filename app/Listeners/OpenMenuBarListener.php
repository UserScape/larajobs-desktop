<?php

namespace App\Listeners;

use Native\Laravel\Events\Notifications\NotificationClicked;
use Native\Laravel\Facades\MenuBar;

class OpenMenuBarListener
{
    /**
     * Handle the event.
     */
    public function handle(NotificationClicked $event): void
    {
        MenuBar::show();
    }
}
