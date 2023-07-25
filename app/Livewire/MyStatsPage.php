<?php

namespace App\Livewire;

use Livewire\Component;

class MyStatsPage extends Component
{
    public function render()
    {
        return view('livewire.my-stats-page', [
            'title' => 'My Statistic',
        ]);
    }
}
