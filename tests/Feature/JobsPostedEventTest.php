<?php

namespace Tests\Feature;

use App\Enums\FilterField;
use App\Enums\FilterOperation;
use App\Events\JobsPosted;
use App\Models\Filter;
use App\Models\JobPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobsPostedEventTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_notifies_of_new_jobs()
    {
        $job = JobPost::factory()->create();

        $event = new JobsPosted();

        // Unfortunately we can't mock the NativePHP Notification
        // facade, so instead we're just going to ensure that the
        // jobs within the event contain what we're expecting to
        // notify the user about.
        $this->assertContains($job->id, $event->jobs->pluck('id'));
    }

    public function test_it_only_notifies_of_jobs_meeting_notification_preference_criteria_when_filter_added()
    {
        Filter::factory()->create([
            'field' => FilterField::Title,
            'operation' => FilterOperation::NotContains,
            'query' => 'Junior'
        ]);

        $job = JobPost::factory()->create([
            'title' => 'Junior Developer'
        ]);

        $event = new JobsPosted();

        // Unfortunately we can't mock the NativePHP Notification
        // facade, so instead we're just going to ensure that the
        // jobs within the event contain what we're expecting to
        // notify the user about.
        $this->assertNotContains($job->id, $event->jobs->pluck('id'));
    }
}