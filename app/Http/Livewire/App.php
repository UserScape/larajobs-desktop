<?php

namespace App\Http\Livewire;

use App\Events\JobsPosted;
use App\Models\JobPost;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class App extends Component
{
    public Collection $jobs;
    public bool $showSettings = false;

    protected $listeners = [
        'settingsButtonClicked' => 'toggleSettings',
        JobsPosted::class => 'handleJobsPosted',
    ];

    public function handleJobsPosted(JobsPosted $event)
    {
        $this->jobs = $event->jobs;
    }

    public function render()
    {
        $this->jobs = JobPost::filtered()->get();

        return view('livewire.app');
    }

    public function toggleSettings()
    {
        $this->showSettings = !$this->showSettings;
    }
}
