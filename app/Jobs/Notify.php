<?php

namespace App\Jobs;

use App\Utility\WatchingDataUtility;
use App\Utility\LaraJobsReader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Date;
use Native\Laravel\Client\Client;
use Native\Laravel\Notification;

class Notify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $matchingJobs = (new LaraJobsReader)->getMatchingItems();
        $matchingJobs = array_filter($matchingJobs, function ($job) {
            return $job['pubDate'] > WatchingDataUtility::getWatching()['last_checked'];
        });

        $client = new Client();
        $notification = new Notification($client);

        if (count($matchingJobs) === 1) {
            $notification->title('New Job!')
            ->message($matchingJobs[0]['title'])
            ->show();
        } else {
            $notification->title('New Jobs!')
            ->message('There are ' . count($matchingJobs) . ' new jobs available.')
            ->show();
        }

        $this->updateWatchingData();
    }

    /**
     * Update the last checked time
     *
     * @param array $userPreferences
     * @return void
     */
    private function updateWatchingData(): void {
        $userPreferences = WatchingDataUtility::getWatching();
        $userPreferences['last_checked'] = time();
        WatchingDataUtility::setWatching($userPreferences);
    }
}
