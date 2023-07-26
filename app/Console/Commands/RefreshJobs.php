<?php

namespace App\Console\Commands;

use App\Jobs\FetchNewJobs;
use Illuminate\Console\Command;

class RefreshJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larajobs:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the jobs from the API.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        FetchNewJobs::dispatchSync();
    }
}
