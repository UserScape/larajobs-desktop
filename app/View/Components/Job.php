<?php

namespace App\View\Components;

use App\Models\JobPost as JobPostModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Job extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  ModelsJob $job
     * @return void
     */
    public function __construct(public JobPostModel $job)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.job');
    }
}