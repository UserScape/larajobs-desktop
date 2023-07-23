<?php

namespace App\Console\Commands;

use App\Services\FeedService;
use Illuminate\Console\Command;

class LaraJobsRefreshFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larajobs:refresh-feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the application with LaraJobs RSS feed';

    /**
     * Execute the console command.
     */
    public function handle(FeedService $feedService)
    {
        $feedService->refresh();
    }
}
