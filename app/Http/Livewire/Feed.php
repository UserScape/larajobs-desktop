<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Vedmant\FeedReader\Facades\FeedReader;

class Feed extends Component
{
    public function render()
    {
        $feed = FeedReader::read('https://larajobs.com/feed');
        return view('livewire.feed', [
            'feed' => $feed
        ]);
    }
}
