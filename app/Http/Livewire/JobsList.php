<?php

namespace App\Http\Livewire;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class JobsList extends Component
{
    public Collection $jobs;

    public function render()
    {
        $this->jobs = JobPost::get();

        return view('livewire.jobs-list');
    }
}
