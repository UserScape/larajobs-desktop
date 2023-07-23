<?php

namespace App\Listeners;

use App\Services\FeedService;
use Native\Laravel\Events\App\OpenedFromURL;

class HandleRefreshFeedLink
{
    private FeedService $feedService;

    /**
     * Create the event listener.
     */
    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }

    /**
     * Handle the event.
     */
    public function handle(OpenedFromURL $event): void
    {
        if ($event->url === config('nativephp.deeplink_scheme').'://refresh') {
            $this->feedService->refresh();
        }
    }
}
