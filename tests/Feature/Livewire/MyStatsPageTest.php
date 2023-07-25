<?php

namespace Tests\Feature\Livewire;

use App\Livewire\MyStatsPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class MyStatsPageTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(MyStatsPage::class)
            ->assertStatus(200);
    }
}
