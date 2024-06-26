<?php

namespace App\Jobs;

use App\Models\JobPost;
use App\Models\JobCreator;
use App\Models\JobTag;
use App\Events\JobsPosted;
use App\Services\RSSDataService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use SimpleXMLElement;

class FetchNewJobs implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public bool $notifyEmpty = false)
    {
    }

    /**
     * Execute the job.
     *
     * @param  RSSDataService $rssDataService
     */
    public function handle(RSSDataService $rssDataService): void
    {
        // Fetch the feed
        try {
            $feed = $rssDataService->get();
        } catch (\Exception $e) {
            return;
        }

        // Get the last build date of the RSS feed.
        $lastBuildDate = Carbon::parse((string) $feed->channel->lastBuildDate);

        // Get the latest post from the database
        $newestPost = JobPost::orderBy('published_at', 'desc')->first();

        // Check if this feed has already been processed
        if ($newestPost && $newestPost->published_at->eq($lastBuildDate)) {
            // Nothing to do
        } else {
            foreach ($feed->channel->item as $post) {
                $this->storeJobPost($post);
            }
        }

        // Fire the event
        $this->notifyJobsPosted();
    }

    /**
     * Notify the user of new jobs that have been posted.
     * If the user has defined filters for their notification preference,
     * we'll only notify them of jobs that match their criteria.
     */
    protected function notifyJobsPosted()
    {
        $jobs = JobPost::visible()
            ->unnotified()
            ->filtered()
            ->orderBy('published_at', 'desc')
            ->get();

        event(new JobsPosted($jobs, $this->notifyEmpty));
    }

    /**
     * Attempt to store a job
     */
    protected function storeJobPost(SimpleXMLElement $post): ?JobPost
    {
        $id = str_replace('https://larajobs.com/job/', '', (string) $post->guid);

        // Ignore jobs that already exist
        if (JobPost::where('id', $id)->exists()) {
            return null;
        }

        // Load the namespaced data
        $namespaces = $post->getNameSpaces(true);
        $jobData = $post->children($namespaces['job']);

        // Find or create the creator record
        $creatorName = trim((string) $post->children($namespaces['dc'])->creator);
        $creator = JobCreator::firstOrCreate([
            'name' => $creatorName,
            'slug' => Str::slug($creatorName),
        ]);

        // Find or create the tag records
        $tagNames = isset($jobData->tags) ? explode(',', (string) $jobData->tags) : [];
        $tagIds = collect($tagNames)->map(function ($tagName) {
            if (empty($tagName)) {
                return;
            }

            // Slug is generated from the tag name
            $slug = Str::slug($tagName);

            // Find or create the tag based on name and slug
            return JobTag::firstOrCreate(['name' => $tagName, 'slug' => $slug])->id;
        })->all();

        $companyLogo = isset($jobData->company_logo) && pathinfo((string) $jobData->company_logo, PATHINFO_EXTENSION) ?
            (string) $jobData->company_logo :
            null;

        // Create the JobPost
        $jobPost = JobPost::create([
            'id' => $id,
            'job_creator_id' => $creator->id,
            'title' => $this->getStringValue($post, 'title'),
            'link' => $this->getStringValue($post, 'link'),
            'category' => $this->getStringValue($post, 'category'),
            'type' => $this->getStringValue($jobData, 'job_type'),
            'salary' => $this->getStringValue($jobData, 'salary'),
            'location' => $this->getStringValue($jobData, 'location'),
            'company' => $this->getStringValue($jobData, 'company'),
            'company_logo' => $companyLogo,
            'published_at' => Carbon::parse((string) $post->pubDate),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Sync the tags
        $jobPost->tags()->sync($tagIds);

        return $jobPost;
    }

    protected function getStringValue(SimpleXMLElement $post, string $key): ?string
    {
        return isset($post->{$key}) ? html_entity_decode(trim((string) $post->{$key})) : null;
    }
}
