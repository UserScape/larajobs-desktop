<?php

namespace App\Http\Controllers;

use App\Utility\WatchingDataUtility;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WatchingController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('watching', [
            'watching' => WatchingDataUtility::getWatching(),
        ]);
    }

    /**
     * Edit the watching data
     */
    public function update(Request $request)
    {
        $watching = WatchingDataUtility::getWatching();
        $watching['tags'] = $request->tags;
        $watching['salary'] = [
            'min' => $request->salary['min'],
            'currency' => $request->salary['currency'],
        ];
        $watching['full_time'] = $request->full_time;

        WatchingDataUtility::setWatching($watching);
    }
}
