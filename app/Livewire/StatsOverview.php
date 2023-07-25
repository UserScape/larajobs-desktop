<?php

namespace App\Livewire;

use App\Models\JobItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Blade;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Jobs applied', JobItem::query()
                ->whereNotNull('applied_at')
                ->count()),
            Card::make('Jobs applied last 1 year', JobItem::query()
                ->whereNotNull('applied_at')
                ->whereBetween('published_at', [now()->subYear(), now()])
                ->count()),
            Card::make('Available jobs last 7 days', JobItem::query()
                ->whereBetween('published_at', [now()->subWeek(), now()])
                ->count()),
            Card::make('Not interested', JobItem::query()
                ->onlyTrashed()
                ->count()),
        ];
    }

    public function placeholder()
    {
        return Blade::render('<div style="width: 5rem; margin: 0 auto">
            <x-filament::loading-indicator />
        </div>');
    }
}
