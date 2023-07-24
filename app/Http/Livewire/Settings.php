<?php

namespace App\Http\Livewire;

use App\Models\Filter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Settings extends Component
{
    public bool $notificationsEnabled;
    public bool $addNewFilter = false;
    public Collection $filters;
    protected $listeners = [
        'toggleNotificationPreference',
        'filterAdded' => 'handleFilterAdded',
        'cancelAddFilter' => 'closeFilterWindow',
    ];

    public function __construct()
    {
        $this->notificationsEnabled = Storage::has('notifications-enabled');
        $this->filters = Filter::orderBy('created_at')->get();
    }

    public function render()
    {
        return view('livewire.settings');
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

    public function toggleNotificationPreference()
    {
        if ($this->notificationsEnabled) {
            Storage::delete('notifications-enabled');
        } else {
            Storage::put('notifications-enabled', true);
        }
    }
}
