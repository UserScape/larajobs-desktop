<?php

namespace App\Jobs;

use App\Events\JobPosted;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class FetchNewJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected SimpleXMLElement $rss;

    /**
     * The RSS feed contains namespaced keys, so we'll need to get them all.
     */
    protected function getAllTags(SimpleXMLElement $el)
    {
        foreach ($el->getNamespaces(true) as $prefix => $ns) {
            $children = $el->children($ns);
            foreach ($children as $tag => $content) {
                $el->{$prefix . ':' . $tag} = $content;
            }
        }

        return $el;
    }

    /**
     * Determines if the RSS feed has updated since we last read it.
     */
    protected function hasUpdatedSince()
    {
        // Get the last build date of the RSS feed.
        $lastBuildDate = Carbon::createFromFormat(Carbon::RSS, (string) $this->rss->channel->lastBuildDate);

        // Now get our last timestamp, if present.
        $lastUpdated = Storage::get('last_updated');

        if (!$lastUpdated) {
            // We haven't pulled the RSS feed before, so we'll assume it's new.
            return true;
        }

        try {
            $lastUpdated = Carbon::createFromTimestamp($lastUpdated);
        } catch (\Exception $e) {
            // We couldn't parse the timestamp, so we'll assume the one we have
            // in the cache is corrupt, and we'll fetch a new one.
            return true;
        }

        // If the last build date is newer than our last updated timestamp,
        // we'll assume there are new jobs.
        return $lastBuildDate->greaterThan($lastUpdated);
    }

    /**
     * Records the last time we pulled the RSS feed.
     */
    protected function persistLastUpdated(): self
    {
        Storage::put('last_updated', time());

        return $this;
    }

    /**
     * Persists the job in the database and emits the event
     */
    protected function persistJob(SimpleXMLElement $job): self
    {
        $this->getAllTags($job);

        $id = str_replace('https://larajobs.com/job/', '', (string) $job->guid);

        // If we already have the job, ignore.
        if (Job::find($id)) {
            return $this;
        }

        $job = Job::create([
            'id' => $id,
            'title' => trim($job->title),
            'link' => $job->link,
            'creator' => trim($job->{"dc:creator"}),
            'category' => trim($job->category),
            'location' => $job->{"job:location"},
            'job_type' => $job->{"job:job_type"},
            'salary' => $job->{"job:salary"},
            'company' => trim($job->{"job:company"}),
            'company_logo' => $job->{"job:company_logo"},
            'published_at' => Carbon::createFromFormat(Carbon::RSS, (string) $job->pubDate),
        ]);

        $tags = explode(',', $job->{"job:tags"});

        $job->tags()->createMany(
            array_map(fn ($tag) => ['tag' => $tag], $tags)
        );

        event(new JobPosted($job));

        return $this;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Fetch the RSS feed
        $xml = file_get_contents(config('app.larajobs_rss'));
        $this->rss = new SimpleXMLElement($xml);

        if (!$this->hasUpdatedSince()) {
            // Nothing has updated since we last run.
            return;
        }

        $this->persistLastUpdated();

        foreach ($this->rss->channel->item as $el) {
            $this->persistJob($el);
        }
    }
}
