<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class WatchingController extends Controller
{

    /**
     * Get watching data from database
     *
     * @return Array
     */
    private function getWatching(): Array {
        try {
            $watching = file_get_contents(database_path('watching.json'));
            $watching = json_decode($watching, true);
            if (!isset($watching['tags'])) {
                $watching['tags'] = [];
            }
            if (!isset($watching['salary'])) {
                $watching['salary'] = [
                    'min' => null,
                    'currency' => null,
                ];
            }
            if (!isset($watching['full_time'])) {
                $watching['full_time'] = null;
            }
        } catch (\Throwable) {
            $watching = [
                'tags' => [],
                'salary' => [
                    'min' => null,
                    'currency' => null,
                ],
                'full_time' => null
            ];
            file_put_contents(database_path('watching.json'), json_encode($watching));
        }
        return $watching;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('watching', [
            'watching' => $this->getWatching(),
        ]);
    }

    /**
     * Edit the watching data
     */
    public function update(Request $request)
    {
        $watching = $this->getWatching();
        $watching['tags'] = $request->tags;
        $watching['salary'] = [
            'min' => $request->salary['min'],
            'currency' => $request->salary['currency'],
        ];
        $watching['full_time'] = $request->full_time;

        file_put_contents(database_path('watching.json'), json_encode($watching));
    }
}
