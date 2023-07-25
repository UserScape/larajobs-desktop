<?php

namespace App\RSS;

use Illuminate\Support\Carbon;

class Larajobs
{
    protected $url;

    private $syNamespaceUrl = 'http://purl.org/rss/1.0/modules/syndication/';

    private $dcNamespaceUrl = 'http://purl.org/dc/elements/1.1/';

    private $larajobNamespaceUrl = 'https://larajobs.com';

    private $syNamespace;

    private $dcNamespace;

    private $larajobNamespace;

    /**
     * Setup the URL
     */
    public function __construct()
    {
        $this->url = env('LARAJOB_RSS_FEED_URL', '');
    }

    /**
     * Set Namespaces for the Feed
     * @param SimpleXMLElement The Feed data
     *
     * @return void
     */
    private function setNamespaces($rssFeedData): void
    {
        $this->syNamespace = $rssFeedData->children($this->syNamespaceUrl);
        $this->dcNamespace = $rssFeedData->children($this->dcNamespaceUrl);
        $this->larajobNamespace = $rssFeedData->children($this->larajobNamespaceUrl);
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
        $location = $job->children('job', true)->location;
        $company = $job->children('job', true)->company;
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
        $jobs = [];
        for ($i = 0; $i < $numberOfJobs; $i++) {
            $jobs[] = $this->getJob();
        }

        return $jobs;
    }
}