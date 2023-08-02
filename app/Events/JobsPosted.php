<?php

namespace App\Events;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobsPosted
{
    use Dispatchable, SerializesModels;

    public Collection $jobs;

    /**
     * Create a new event instance.
     */
    public function __construct(public bool $notifyEmpty = false)
    {
        $this->jobs = JobPost::visible()
            ->unnotified()
            ->filtered()
            ->orderBy('published_at', 'desc')
            ->get();
    }
}
