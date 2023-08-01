<?php

namespace App\Listeners;

use App\Events\JobsPosted;
use App\Models\JobPost;
use Illuminate\Database\Eloquent\Collection;
use Native\Laravel\Notification;

class SendNewJobsNotification
{
    protected const EVENT_CLICK_PREFIX = 'notification.clicked.';

    /**
     * Handle the JobsPosted event
     */
    public function handle(JobsPosted $event)
    {
        if ($event->jobs->count() === 1) {
            $this->handleSingularJob($event->jobs->first());
        } elseif ($event->jobs->count() > 1) {
            $this->handleMultipleJobs($event->jobs);
        } elseif ($event->jobs->isEmpty() && $event->notifyEmpty) {
            $this->handleEmptyNotification();
        }
    }

    /**
     * Notify the user of a single new job that's been posted.
     * After notifying, update the job to record that it's been notified.
     */
    protected function handleSingularJob(JobPost $job): void
    {
        $message = $job->title;

        if (!empty($job->salary)) {
            $message .= ': ' . $job->salary;
        }

        Notification::new()
            ->title("New job from {$job->creator->name}")
            ->message($message)
            ->event(self::EVENT_CLICK_PREFIX . 'newjob.'. $job->id)
            ->show();

        $job->update([
            'notified_at' => now(),
        ]);
    }

    /**
     * Notify the user of multiple new jobs that have been posted.
     * After notifying, update the jobs to record that they've been notified.
     */
    protected function handleMultipleJobs(Collection $jobs): void
    {
        Notification::new()
            ->title("View the latest jobs")
            ->message("{$jobs->count()} new jobs available.")
            ->event(self::EVENT_CLICK_PREFIX . 'newjobs')
            ->show();

        JobPost::whereIn('id', $jobs->pluck('id'))
            ->update([
                'notified_at' => now(),
            ]);
    }

    /**
     * Notify the user that there are no new jobs available.
     * This is only called if the notifyEmpty flag is set to true.
     */
    protected function handleEmptyNotification(): void
    {
        Notification::new()
            ->title("No new jobs")
            ->message("There are no new jobs available.")
            ->event(self::EVENT_CLICK_PREFIX . 'nojobs')
            ->show();
    }
}
