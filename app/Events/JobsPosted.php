<?php

namespace App\Events;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobsPosted
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Collection $jobs, public bool $notifyEmpty = false)
    {
    }
}