<?php

namespace App\Listeners;

use App\Jobs\FetchNewJobs;

class HandleGlobalShortcutRefresh
{
    /**
     * Handle the event.
     */
    public function handle()
    {
        FetchNewJobs::dispatchSync(true);
    }
}