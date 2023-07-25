<?php

namespace App\Http\Controllers;

use App\Utility\LaraJobsReader;
use App\Utility\RssFeedLoader;
use App\Utility\SalaryRange;
use Inertia\Inertia;

class FeedsController extends Controller
{
    public function index()
    {
        $jobs = (new LaraJobsReader)->getMatchingItems();

        return Inertia::render('index', [
            'jobs' => $jobs,
        ]);
    }
}
