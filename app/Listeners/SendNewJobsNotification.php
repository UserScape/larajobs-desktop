<?php

namespace App\Listeners;

use App\Events\JobsPosted;
use App\Models\JobPost;
use Carbon\Carbon;
use Native\Laravel\Client\Client;
use Native\Laravel\Notification;

class SendNewJobsNotification
{
    public function handle(JobsPosted $event)
    {
        $jobs = $event->jobs;
        $notifyEmpty = $event->notifyEmpty;

        $client = new Client();
        $notification = new Notification($client);
        $now = Carbon::now();
        $newCount = count($jobs);

        if ($newCount === 1) {
            $job = $jobs[0];

            $message = $job->title;

            if (!empty($job->salary)) {
                $message .= ': ' . $job->salary;
            }
            $notification
                ->title("New job from {$job->creator->name}")
                ->message($message)
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

            JobPost::whereIn('id', collect($jobs)->pluck('id')->toArray())
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
