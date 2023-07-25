<?php

namespace App\Listeners;

use App\Jobs\FetchNewJobs;
use Illuminate\Support\Str;
use Native\Laravel\Events\App\OpenedFromURL;

class HandleDeepLink
{
    /**
     * Handle the event.
     */
    public function handle(OpenedFromURL $event): void
    {
        $prefix = config('nativephp.deeplink_scheme').'://';
        if (!Str::startsWith($event->url, $prefix)) {
            return;
        }

        $method = 'handle' . ucfirst(Str::after($event->url, $prefix));
        if (method_exists($this, $method)) {
            $this->{$method}($event);
        }
    }

    public function handleRefresh(): void
    {
        FetchNewJobs::dispatchSync(true);
    }
}