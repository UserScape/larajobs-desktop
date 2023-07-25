<?php

namespace App\Listeners;

use Native\Laravel\Facades\MenuBar;

class OpenMenuBar
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
    public function handle(object $event): void
    {
        MenuBar::show();
    }
}
