<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Events\ClickedJob;
use App\Models\Larajob;
use Carbon\Carbon;
use Native\Laravel\Client\Client;
use Native\Laravel\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PollLarajobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:poll-larajobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Poll Larajobs RSS';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::debug('Polling Larajobs');

        if(!Storage::exists('first_run'))
            Storage::put('first_run', now()->timestamp);

        $rss_feed = file_get_contents(
            config('notifier.rss_feed'),
            false,
            stream_context_create([
                'ssl' => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ]
            ])
        );

        $firstRun = Carbon::createFromTimestamp(Storage::get('first_run'));

        $rss = simplexml_load_string($rss_feed);

        foreach($rss->channel->item as $item) {
            $pub_date = Carbon::parse((string) $item->pubDate);

            $job = [
                'pub_date' => $pub_date,
                'link' => (string) $item->link,
                'title' => (string) $item->title,
                'icon' => (string) $item->children('job', true)->company_logo,
                'salary' => (string) $item->children('job', true)->salary,
                'company' => (string) $item->children('job', true)->company,
                'location' => (string) $item->children('job', true)->location,
                'tags' => (string) $item->children('job', true)->tags,
                'job_type' => (string) $item->children('job', true)->job_type,
                'seen' => $pub_date->lt($firstRun)
            ];

            if(Larajob::where('link', $job['link'])->exists())
                continue;

            $larajob = Larajob::create($job);

            if($larajob->seen)
                continue;

            list(
                'company' => $company,
                'location' => $location,
                'salary' => $salary,
            ) = $job;

            (new Notification(new Client()))
                ->title('LaraJobs - New job posted!')
                ->message("{$company} - {$location}" . (!empty($salary) ? " ({$salary})" : ''))
                ->event(ClickedJob::class)
                ->show();
        };
    }
}
