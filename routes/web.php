<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/menubar/', function () {
    $content = file_get_contents('https://larajobs.com/feed-test');
    $cacheKey = 'larajobs-feed-contents.' . md5($content);

    $jobs = Cache::remember($cacheKey, Carbon::now()->addWeek(1), function () use ($content) {
        $jobs = [];
        $xml = simplexml_load_string($content);

        $jobs = [];
        foreach ($xml->channel->item as $item) {
            $namespaces = $item->getNameSpaces(true);
            $jobData = $item->children($namespaces['job']);

            $job = [
                'title' => (string) $item->title,
                'url' => (string) $item->link,
                'published_at' => Carbon::parse((string) $item->pubDate),
                'creator' => (string) $item->children($namespaces['dc'])->creator,
                'location' => isset($jobData->location) ? (string) $jobData->location : null,
                'type' => isset($jobData->job_type) ? (string) $jobData->job_type : null,
                'salary' => isset($jobData->salary) ? (string) $jobData->salary : null,
                'company' => isset($jobData->company) ? (string) $jobData->company : null,
                'company_logo' => isset($jobData->company_logo) && pathinfo((string) $jobData->company_logo, PATHINFO_EXTENSION) ? (string) $jobData->company_logo : null,
                'tags' => isset($jobData->tags) ? explode(',', (string) $jobData->tags) : [],
            ];

            foreach ($job as $key => &$value) {
                if (is_string($value)) {
                    $value = html_entity_decode($value);
                }
            }
            unset($value);

            $jobs[] = $job;
        }

        return $jobs;
    });

    return view('menubar.index', ['jobPosts' => $jobs]);
})->name('menubar.index');
