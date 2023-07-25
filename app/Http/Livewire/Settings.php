<?php

namespace App\Http\Livewire;

use App\Models\FilterRule;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Native\Laravel\Facades\Settings as NativeSettings;

class Settings extends Component
{
    public bool $notificationsEnabled;
    public bool $addNewFilter = false;
    public Collection $filterRules;
    protected $listeners = [
        'toggleNotificationPreference',
        'filterAdded' => 'handleFilterAdded',
        'cancelAddFilter' => 'closeFilterWindow',
    ];

    public function __construct()
    {
        $this->notificationsEnabled = NativeSettings::get('notifications-enabled');
        $this->filterRules = FilterRule::orderBy('created_at')->get();
    }

    public function render()
    {
        return view('livewire.settings');
    }

    public function deleteFilter(FilterRule $filter)
    {
        $filter->delete();
        $this->filterRules = FilterRule::orderBy('created_at')->get();
    }

    public function handleFilterAdded()
    {
        $this->closeFilterWindow();
        $this->filterRules = FilterRule::orderBy('created_at')->get();
    }

    public function closeFilterWindow()
    {
        $this->addNewFilter = false;
    }

    public function toggleNotificationPreference()
    {
        NativeSettings::set('notifications-enabled', $this->notificationsEnabled);
    }
}