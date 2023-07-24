<?php

namespace App\Http\Livewire;

use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Native\Laravel\Notification;

class App extends Component
{
    public Collection $jobs;
    public bool $showSettings = false;

    protected $listeners = [
        'settingsButtonClicked' => 'toggleSettings',
        'native:' . \App\Events\NotifyOfNewJob::class => 'handleJobPosted',
    ];

    public function handleJobPosted(Job $job)
    {
        Notification::new()
            ->title($job->title)
            ->message("{$job->company} is hiring!")
            ->show();

        $this->jobs = Job::filtered()->get();
    }

    public function render()
    {
        $this->jobs = Job::filtered()->get();

        return view('livewire.app');
    }

    public function toggleSettings()
    {
        $this->showSettings = !$this->showSettings;
    }
}
