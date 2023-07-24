<?php

namespace App\View\Components;

use App\Models\Job as ModelsJob;
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
    public function __construct(public ModelsJob $job)
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
