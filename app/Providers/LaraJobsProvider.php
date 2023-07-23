<?php

namespace App\Providers;

use App\Services\FeedService;
use Illuminate\Support\ServiceProvider;

class LaraJobsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FeedService::class, function () {
            return new FeedService(config('larajobs.feed.url'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
