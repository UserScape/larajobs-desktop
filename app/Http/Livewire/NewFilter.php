<?php

namespace App\Http\Livewire;

use App\Models\FilterRule;
use Livewire\Component;

class NewFilter extends Component
{
    public FilterRule $filter;

    public $rules = [
        'filter.field' => ['required', 'in:\App\Enums\FilterField'],
        'filter.operation' => 'required', 'in:\App\Enums\FilterOperation',
        'filter.query' => ['required'],
    ];

    public function __construct()
    {
        $this->filter = new FilterRule();
    }

    public function addFilter()
    {
        // $this->validate();

        $this->filter->save();

        $this->emit('filterAdded');
    }

    public function render()
    {
        return view('livewire.new-filter');
    }
}