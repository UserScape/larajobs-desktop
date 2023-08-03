<?php

namespace Tests\Feature;

use App\Enums\FilterField;
use App\Enums\FilterOperation;
use App\Events\JobsPosted;
use App\Jobs\FetchNewJobs;
use App\Models\Filter;
use App\Services\RSSDataService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use SimpleXMLElement;
use Tests\TestCase;

class FetchNewJobsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake([
            JobsPosted::class,
        ]);
    }

    protected function mockRssResponse() {
        $this->mock(RSSDataService::class, function ($mock) {
            $mock->shouldReceive('get')->andReturn(new SimpleXMLElement('
                <rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" xmlns:job="https://larajobs.com" version="2.0">
                    <channel>
                        <lastBuildDate>Thu, 03 Aug 2023 01:00:00 +0000</lastBuildDate>
                        <item>
                            <title>Junior beer taster</title>
                            <link>https://larajobs.com/job/1075</link>
                            <pubDate>Thu, 03 Aug 2023 01:00:00 +0000</pubDate>
                            <dc:creator><![CDATA[ Beer Factory Ltd. ]]></dc:creator>
                            <category><![CDATA[ Job ]]></category>
                            <job:location><![CDATA[ London, GB ]]></job:location>
                            <job:job_type><![CDATA[ ]]></job:job_type>
                            <job:salary><![CDATA[ ]]></job:salary>
                            <job:company><![CDATA[ Beer Factory Ltd. ]]></job:company>
                            <job:company_logo></job:company_logo>
                            <job:tags><![CDATA[ ]]></job:tags>
                            <guid isPermaLink="false">https://larajobs.com/job/1075</guid>
                            <description><![CDATA[ ]]></description>
                            <content:encoded><![CDATA[ ]]></content:encoded>
                        </item>
                    </channel>
                </rss>'
            ));
        });
    }

    public function test_it_persists_jobs()
    {
        // Now pretend that the RSS feed came back with a junior role
        $this->mockRssResponse();

        // Dispatch the job
        FetchNewJobs::dispatch();

        $this->assertDatabaseHas('job_posts', [
            'title' => 'Junior beer taster'
        ]);
    }

    public function test_it_notifies_of_job_that_meets_notification_criteria_when_filter_added()
    {
        // We'll create a filter that excludes jobs with the word "Junior" in the title
        Filter::factory()->create([
            'field' => FilterField::Title,
            'operation' => FilterOperation::Contains,
            'query' => 'beer'
        ]);

        // Now pretend that the RSS feed came back with a junior role
        $this->mockRssResponse();

        // Dispatch the job
        FetchNewJobs::dispatch();

        // Assert that the event was dispatched with no jobs
        Event::assertDispatched(JobsPosted::class, function ($event) {
            return $event->jobs->count() === 1;
        });
    }

    public function test_it_doesnt_notify_of_job_that_doesnt_meet_notification_criteria_when_filter_added()
    {
        // We'll create a filter that excludes jobs with the word "Junior" in the title
        Filter::factory()->create([
            'field' => FilterField::Title,
            'operation' => FilterOperation::NotContains,
            'query' => 'Junior'
        ]);

        // Now pretend that the RSS feed came back with a junior role
        $this->mockRssResponse();

        // Dispatch the job
        FetchNewJobs::dispatch();

        // Assert that the event was dispatched with no jobs
        Event::assertDispatched(JobsPosted::class, function ($event) {
            return $event->jobs->count() === 0;
        });
    }
}