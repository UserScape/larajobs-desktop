<?php

namespace App\Listeners;

use App\Models\JobItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Native\Laravel\Events\App\ApplicationBooted;
use Native\Laravel\Notification;

class NotifyJobSummariesListener
{
    public function handle(ApplicationBooted $event): void
    {
        $message = now()->isWeekday()
            ? "It's time to ship!"
            : "It's a nice weekend!";

        $jobsCount = JobItem::query()
            ->whereNull('applied_at')
            ->whereBetween('published_at', [now(), now()->subDay()])
            ->count();

        if (! empty($jobsCount)) {
            $message = 'You have ' . $jobsCount . ' jobs which might interest you.';
        }

        Notification::new()
            ->title('Welcome back, artisan!')
            ->message($message)
            ->show();
    }
}
