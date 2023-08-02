<?php

namespace Tests\Feature;

use App\Enums\FilterField;
use App\Enums\FilterOperation;
use App\Events\JobsPosted;
use App\Models\Filter;
use App\Models\JobCreator;
use App\Models\JobPost;
use Illuminate\Database\Eloquent\Collection;
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
        $job = JobPost::factory()->create();

        Notification::shouldReceive('new->title->message->event->show')->once();

        event(new JobsPosted(Collection::make([$job])));
    }

    public function test_the_notification_contains_the_expected_content_for_singular_job_alerts()
    {
        $creator = JobCreator::factory()->create(['name' => 'Beer Factory Ltd.']);
        $job = JobPost::factory()->for($creator, 'creator')->create([
            'title' => 'Full-stack beer taster',
            'salary' => '#100k'
        ]);

        Notification::shouldReceive('new')->andReturnSelf();
        Notification::shouldReceive('title')->with("New job from Beer Factory Ltd.")->once()->andReturnSelf();
        Notification::shouldReceive('message')->with('Full-stack beer taster: #100k')->once()->andReturnSelf();
        Notification::shouldReceive('event')->once()->andReturnSelf();
        Notification::shouldReceive('show')->once();

        event(new JobsPosted(Collection::make([$job])));
    }

    public function test_the_notification_contains_the_expected_title_for_multiple_job_alerts()
    {
        $creator = JobCreator::factory()->create(['name' => 'Beer Factory Ltd.']);
        $jobs = JobPost::factory()->for($creator, 'creator')->times(2)->create();

        Notification::shouldReceive('new')->andReturnSelf();
        Notification::shouldReceive('title')->with("View the latest jobs")->once()->andReturnSelf();
        Notification::shouldReceive('message')->with("2 new jobs available.")->once()->andReturnSelf();
        Notification::shouldReceive('event')->once()->andReturnSelf();
        Notification::shouldReceive('show')->once();

        event(new JobsPosted($jobs));
    }

    public function test_it_notifies_when_no_jobs_present_if_notify_empty_set_to_true()
    {
        Notification::shouldReceive('new')->andReturnSelf();
        Notification::shouldReceive('title')->with("No new jobs")->once()->andReturnSelf();
        Notification::shouldReceive('message')->with("There are no new jobs available.")->once()->andReturnSelf();
        Notification::shouldReceive('event')->once()->andReturnSelf();
        Notification::shouldReceive('show')->once();

        event(new JobsPosted(Collection::make(), true));
    }
}