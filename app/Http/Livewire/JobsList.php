<?php

namespace App\Http\Livewire;

use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class JobsList extends Component
{
    public Collection $jobs;

    public function render()
    {
        $this->jobs = Job::get();

        return view('livewire.jobs-list');
    }
}
