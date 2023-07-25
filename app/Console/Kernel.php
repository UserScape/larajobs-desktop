<?php

namespace App\Console;

use App\Models\Job;
use App\RSS\Larajobs;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Native\Laravel\Facades\Notification;
use Native\Laravel\Facades\MenuBar;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $larajobsRSSFeed = new Larajobs();
            $job = $larajobsRSSFeed->getJob();
            Job::create($job);
        })->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
