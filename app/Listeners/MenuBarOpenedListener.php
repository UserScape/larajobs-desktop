<?php

namespace App\Listeners;

use App\Models\Larajob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MenuBarOpenedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Log::debug('Marking as read!');

        Larajob::where('seen', false)
            ->update([
                'seen' => true
            ]);
    }
}
