<?php

namespace App\Http\Livewire;

use App\Models\Filter;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Settings extends Component
{
    public bool $addNewFilter = false;
    public Collection $filters;
    protected $listeners = [
        'toggleNotificationPreference',
        'filterAdded' => 'handleFilterAdded',
        'cancelAddFilter' => 'closeFilterWindow',
    ];

    public function __construct()
    {
        $this->filters = Filter::orderBy('created_at')->get();
    }

    public function render()
    {
        return view('livewire.settings')->layout('components.layout');
    }

    public function deleteFilter(Filter $filter)
    {
        $filter->delete();
        $this->filters = Filter::orderBy('created_at')->get();
    }

    public function handleFilterAdded()
    {
        $this->closeFilterWindow();
        $this->filters = Filter::orderBy('created_at')->get();
    }

    public function closeFilterWindow()
    {
        $this->addNewFilter = false;
    }
}
