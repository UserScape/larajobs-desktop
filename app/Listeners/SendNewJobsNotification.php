<?php

namespace App\Listeners;

use App\Events\JobsPosted;
use App\Models\JobPost;
use Carbon\Carbon;
use Native\Laravel\Client\Client;
use Native\Laravel\Notification;
use Native\Laravel\Facades\Settings;

class SendNewJobsNotification
{
    public function handle(JobsPosted $event)
    {
        if (Settings::get('notifications-enabled', true)) {
            return;
        }

        $validJobIds = JobPost::filtered()->pluck('id')->all();

        $jobs = $event->jobs;
        $jobs = $jobs->filter(function (JobPost $job) use ($validJobIds) {
            return in_array($job->id, $validJobIds);
        });

        $notifyEmpty = $event->notifyEmpty;

        $client = new Client();
        $notification = new Notification($client);
        $now = Carbon::now();
        $newCount = count($jobs);

        if ($newCount === 1) {
            $job = $jobs->first();
            $notification
                ->title("New job from {$job->creator->name}")
                ->message($job->title)
                ->event('notification.clicked.newjob.' . $job->id)
                ->show();

            $job->update([
                'notified_at' => $now,
            ]);
        } elseif ($newCount > 1) {
            $notification
                ->title("View the latest jobs")
                ->message("{$newCount} new jobs available.")
                ->event('notification.clicked.newjobs')
                ->show();

            JobPost::whereIn('id', $jobs->pluck('id')->toArray())
                ->update([
                    'notified_at' => $now,
                ]);
        } elseif ($newCount === 0 && $notifyEmpty) {
            $notification
                ->title("No new jobs")
                ->message("There are no new jobs available.")
                ->event('notification.clicked.nojobs')
                ->show();
        }
    }
}
