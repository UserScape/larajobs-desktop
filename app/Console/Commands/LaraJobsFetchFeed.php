<?php

namespace App\Console\Commands;

use App\Models\Larajobs;
use App\Services\FeedService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Native\Laravel\Client\Client;
use Native\Laravel\Notification;
use Vedmant\FeedReader\Facades\FeedReader;

class LaraJobsFetchFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larajobs:fetch-feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $feed = FeedReader::read('https://larajobs.com/feed-test', 'default');
        foreach ($feed->get_items() as $item) {
            $client = new Client();
            $notification = new Notification($client);
            $notification->title('New job offers')
                ->message($item->get_title())
                ->show();
        }

    }
}
