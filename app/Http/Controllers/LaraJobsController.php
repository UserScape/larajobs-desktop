<?php

namespace App\Http\Controllers;

use App\Models\Larajobs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Native\Laravel\Client\Client;
use Native\Laravel\Notification;
use Vedmant\FeedReader\Facades\FeedReader;

class LaraJobsController extends Controller
{
    public function menubar()
    {
        // Artisan::call('larajobs:fetch-feed');

        // $client = new Client();
        // $notification = new Notification($client);
        // $notification->title('Hello from NativeApp')
        //     ->message('This is a detailed message coming from your native app.')
        //     ->show();


        // $jobs = Larajobs::latest()->take(10)->get();

        $jobs = [];
        $feed = FeedReader::read('https://larajobs.com/feed', 'default');
        foreach ($feed->get_items() as $item) {
            $j = [];
            $j['link'] = $item->get_link();
            $j['title'] = $item->get_title();
            $j['category'] = $item->get_category()->term ?? null;
            $j['creator'] = $item->get_title();
            $j['job_location'] = $item->get_item_tags('https://larajobs.com', 'location')[0]['data'] ?? null;
            $j['job_type'] = $item->get_item_tags('https://larajobs.com', 'job_type')[0]['data'] ?? null;
            $j['job_salary'] = $item->get_item_tags('https://larajobs.com', 'salary')[0]['data'] ?? null;
            $j['job_company'] = $item->get_item_tags('https://larajobs.com', 'company')[0]['data'] ?? null;
            $j['job_company_logo'] = $item->get_item_tags('https://larajobs.com', 'company_logo')[0]['data'] ?? null;
            $j['published_at'] = Carbon::parse($item->get_date())->format("Y-m-d H:i:s");
            $jobs[] = $j;
        }
        return view('menubar', compact('jobs'));
    }
}
