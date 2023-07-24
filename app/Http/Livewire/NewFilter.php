<?php

namespace App\Http\Livewire;

use App\Models\Filter;
use Livewire\Component;

class NewFilter extends Component
{
    public Filter $filter;

    public $rules = [
        'filter.field' => ['required', 'in:\App\Enums\FilterField'],
        'filter.operation' => 'required', 'in:\App\Enums\FilterOperation',
        'filter.query' => ['required'],
    ];

    public function __construct()
    {
        $this->filter = new Filter();
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
