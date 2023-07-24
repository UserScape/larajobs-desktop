<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Header extends Component
{
    public $onClickSettings;
    public bool $settingsOpen;

    public function render()
    {
        return view('livewire.header');
    }
}
