<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Native\Laravel\Facades\Window;

class Job extends Component
{
    public string $link = '';
    public string $title = '';
    public string|null $description = '';
    public string $date = '';
    public string $author = '';
    public string|null $location = '';
    public string|null $job_type = '';
    public string|null $salary = null;
    public string|null $company_logo = '';
    public array|null $tags = [];

    public function mount()
    {
        if($this->company_logo ===  "https://larajobs.com/logos/"){
            $this->company_logo = "https://larajobs.com/img/nologo.svg";
        }
    }

    public function visitJob()
    {
        Window::open()
            ->url($this->link)
            ->width(800)
            ->height(600);
    }
    public function render()
    {
        return view('livewire.job');
    }
}
