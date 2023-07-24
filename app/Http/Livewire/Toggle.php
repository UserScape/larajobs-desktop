<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Toggle extends Component
{
    public bool $model;

    public function render()
    {
        return view('livewire.toggle');
    }
}
