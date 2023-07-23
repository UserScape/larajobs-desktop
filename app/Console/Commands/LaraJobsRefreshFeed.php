<?php

namespace App\Console\Commands;

use App\Models\Jobs;
use App\Services\FeedService;
use Illuminate\Console\Command;
use Native\Laravel\Client\Client;
use Native\Laravel\Notification;

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
        $latestJobs = Jobs::latest()->take(10)->get();

        /**
         * @var \Illuminate\Support\Collection $items
         */
        $items = $feedService->refresh();
        $items = $items->filter(fn ($item) => ! $latestJobs->contains('guid', $item['guid']));

        $latestJob = $items->first();

        $title = '';
        $message = '';

        $numberOfItems = $items->count();

        if ($numberOfItems > 0) {
            if ($numberOfItems < 2) {
                $title = $latestJob['title'];
                $message = $latestJob['creator'];
            } else {
                $title = __('New jobs available');
                $message = __('We have :count new jobs', ['count' => $numberOfItems]);
            }
        }

        if (! $title) {
            return;
        }

        $client = new Client();
        $notification = new Notification($client);

        $notification->title($title)
            ->message($message)
            ->show();
    }
}
