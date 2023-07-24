<?php

namespace App\Listeners;

use App\Events\JobPosted;
use App\Events\NotifyOfNewJob;
use App\Models\Job;
use Illuminate\Support\Facades\Storage;

class MaybeNotifyOfNewJob
{
    /**
     * Handle the event.
     */
    public function handle(JobPosted $event): void
    {
        if (!$this->shouldSendNotification($event->job)) {
            return;
        }

        event(new NotifyOfNewJob($event->job));
    }

    /**
     * Determine if we should send a notification.
     *
     * We'll check if the user has notifications enabled, and if they have
     * any filters, if this job meets their criteria.
     */
    protected function shouldSendNotification(Job $job): bool
    {
        if (Storage::has('notifications-enabled')) {
            return false;
        }

        // Does this job meet the criteria?
        return Job::filtered()->where('id', $job->getKey())->exists();
    }
}
