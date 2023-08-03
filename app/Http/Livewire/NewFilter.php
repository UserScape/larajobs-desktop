<?php

namespace App\Http\Livewire;

use App\Enums\FilterField;
use App\Enums\FilterOperation;
use App\Models\Filter;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class NewFilter extends Component
{
    public $field;
    public $operation;
    public $query;

    public function rules(): array
    {
        return [
            'field' => ['required', new Enum(FilterField::class)],
            'operation' => ['required', new Enum(FilterOperation::class)],
            'query' => ['required'],
        ];
    }

    public function submit()
    {
        $this->validate();

        Filter::create([
            'field' => $this->field,
            'operation' => $this->operation,
            'query' => $this->query,
        ]);

        $this->emit('filterAdded');
    }

    public function render()
    {
        return view('livewire.new-filter');
    }
}
