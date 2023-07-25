<?php

namespace App\RSS;

use App\Models\Job;
use Illuminate\Support\Carbon;

class Larajobs
{
    protected $url;

    /**
     * Setup the URL
     */
    public function __construct()
    {
        $this->url = env('LARAJOB_RSS_FEED_URL', '');
    }

    /**
     * Get a Job Posting
     *
     * @return Array The job data
     */
    public function getJob(): array
    {
        $larajobsRSSRawData = file_get_contents($this->url);
        $larajobsRSSFeed = simplexml_load_string($larajobsRSSRawData, 'SimpleXMLElement', LIBXML_NOCDATA);

        $job = $larajobsRSSFeed->channel->item;
        $title = $job->title;
        $link = $job->link;
        $location = htmlspecialchars_decode($job->children('job', true)->location);
        $company = htmlspecialchars_decode($job->children('job', true)->company);
        $jobType = $job->children('job', true)->jobType;
        $salary = $job->children('job', true)->salary ?? "No Salary Info provided";

        $publishedDate = $job->pubDate;
        $publishedDateInCarbon = Carbon::createFromFormat('D, d M Y H:i:s O', $publishedDate);
        $publishedDateForHumans = $publishedDateInCarbon->diffForHumans();

        return [
            'title' => $title,
            'link' => $link,
            'publishedDate' => $publishedDateForHumans,
            'location' => $location,
            'company' => $company,
            'jobType' => $jobType,
            'salary' => $salary
        ];
    }

    /**
     * Get Multiple Jobs
     * @param Int numberOfJobs The Number of Jobs (defaults to 1)
     *
     * @return Array An array of jobs
     */
    public function getJobs($numberOfJobs = 1): array
    {
        return Job::limit($numberOfJobs)->inRandomOrder()->get()->toArray();
    }
}