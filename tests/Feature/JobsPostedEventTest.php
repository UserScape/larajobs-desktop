<?php

namespace Tests\Feature;

use App\Enums\FilterField;
use App\Enums\FilterOperation;
use App\Events\JobsPosted;
use App\Models\Filter;
use App\Models\JobCreator;
use App\Models\JobPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Native\Laravel\Facades\Notification;
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
        JobPost::factory()->create();

        Notification::shouldReceive('new->title->message->event->show')->once();

        event(new JobsPosted());
    }

    public function test_the_notification_contains_the_expected_content_for_singular_job_alerts()
    {
        $creator = JobCreator::factory()->create(['name' => 'Beer Factory Ltd.']);
        JobPost::factory()->for($creator, 'creator')->create([
            'title' => 'Full-stack beer taster',
            'salary' => '#100k'
        ]);

        Notification::shouldReceive('new')->andReturnSelf();
        Notification::shouldReceive('title')->with("New job from Beer Factory Ltd.")->once()->andReturnSelf();
        Notification::shouldReceive('message')->with('Full-stack beer taster: #100k')->once()->andReturnSelf();
        Notification::shouldReceive('event')->once()->andReturnSelf();
        Notification::shouldReceive('show')->once();

        event(new JobsPosted());
    }

    public function test_the_notification_contains_the_expected_title_for_multiple_job_alerts()
    {
        $creator = JobCreator::factory()->create(['name' => 'Beer Factory Ltd.']);
        JobPost::factory()->for($creator, 'creator')->create();
        JobPost::factory()->for($creator, 'creator')->create();

        Notification::shouldReceive('new')->andReturnSelf();
        Notification::shouldReceive('title')->with("View the latest jobs")->once()->andReturnSelf();
        Notification::shouldReceive('message')->with("2 new jobs available.")->once()->andReturnSelf();
        Notification::shouldReceive('event')->once()->andReturnSelf();
        Notification::shouldReceive('show')->once();

        event(new JobsPosted());
    }

    public function test_it_only_notifies_of_jobs_meeting_notification_preference_criteria_when_filter_added()
    {
        Notification::shouldReceive('new->title->message->event->show')->times(0);

        Filter::factory()->create([
            'field' => FilterField::Title,
            'operation' => FilterOperation::NotContains,
            'query' => 'Junior'
        ]);

        JobPost::factory()->create([
            'title' => 'Junior Developer'
        ]);

        event(new JobsPosted());
    }
}