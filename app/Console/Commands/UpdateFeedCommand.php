<?php

namespace App\Console\Commands;

use App\Models\Timestamp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Native\Laravel\Client\Client;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Notification;
use Vedmant\FeedReader\Facades\FeedReader;

class UpdateFeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larajobs:update-feed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $item = $this->getLatestItem();

        if($this->hasBeenUpdated($item)){
            $client = new Client();
            $notification = new Notification($client);
            $job_type = $item->get_item_tags('https://larajobs.com','job_type')[0]['data'];
            $notification->title('Larajobs.com')
                ->message('New Job: ' . $item->get_author()->name
                    . ' ' . $item->get_item_tags('https://larajobs.com','salary')[0]['data']
                    . ' ' . \Illuminate\Support\Str::replace('_', ' ', \Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::lower($job_type)))
                )
                ->show();
        }
    }

    private function hasBeenUpdated($item): bool
    {
        $filename = 'last_date.txt';
        $latestDate = ($item->get_date());

        if(Storage::exists($filename)){
            $storedDate = Storage::get($filename);
            if($storedDate !== $latestDate){
                Storage::put($filename, $latestDate);
                return true;
            }
            return false;
        }

        Storage::put($filename, $latestDate);
        return false;

    }

    private function getLatestItem()
    {
        $feed = FeedReader::read('https://larajobs.com/feed');
        return $feed->get_items()[0];
    }
}
