<?php

namespace App\Http\Controllers;

use App\RSS\Larajobs;
use Illuminate\Http\Request;

class FetchJobs extends Controller
{
    /**
     * Get list of jobs
     */
    public function __invoke()
    {
        $larajobsRSSFeed = new Larajobs();
        $jobs = $larajobsRSSFeed->getJobs(10);

        return view('welcome', ['jobs' => $jobs]);
    }
}
