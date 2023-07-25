<?php

namespace App\Livewire\JobItemResources\Pages;

use App\Models\Company;
use App\Models\JobItem;
use App\Services\LarajobsService;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Forms;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Filament\Support\Colors\Color;
use Native\Laravel\Facades\Clipboard;
use Native\Laravel\Notification;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

class ListJobItems extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function mount()
    {
        $this->getFeeds(new LarajobsService);
    }

    public function getFeeds(LarajobsService $larajobsService)
    {
        $items = $larajobsService->feedItems();
        foreach ($items as $item) {
            $meta = data_get($item->data, ['child', 'https://larajobs.com']);

            $company = Company::query()->firstOrCreate(['name' => $item->get_author()->get_name()]);

            $logo = data_get($meta, 'company_logo.0.data');

            if ($logo && ! $company->hasMedia('logo')) {
                try {
                    $company->addMediaFromUrl($logo)
                        ->toMediaCollection('logo');
                } catch (UnreachableUrl $e) {
                    //
                }
            }

            $jobItem = JobItem::query()->firstOrCreate([
                'link' => $item->get_id(),
            ], [
                'title' => $item->get_title(),
                'company_id' => $company->getKey(),
                'published_at' => Carbon::parse(data_get($item->data, ['child', '', 'pubDate', 0, 'data'])),
                'location' => data_get($meta, 'location.0.data'),
                'salary' => data_get($meta, 'salary.0.data'),
            ]);

            if ($jobItem->wasRecentlyCreated) {
                Notification::new()
                    ->title("New Larajob: {$jobItem->title}")
                    ->message($jobItem->notification_message)
                    ->show();
            }
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(JobItem::query())
            ->deferLoading()
            ->headerActions([
                Tables\Actions\Action::make('my_stats')
                    ->url('stats')
                    ->openUrlInNewTab(),
            ])
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('is_applied')
                        ->colors(Color::Green)
                        ->icon(fn ($state) => ! $state ? null : 'heroicon-o-check-circle')
                        ->formatStateUsing(fn ($state) => ! $state ? null : 'Job has been applied!'),
                    Tables\Columns\TextColumn::make('title')
                        ->searchable()
                        ->openUrlInNewTab()
                        ->url(fn ($record) => $record->link),
                    Tables\Columns\TextColumn::make('company.name')
                        ->icon('heroicon-o-building-office')
                        ->tooltip('filter by this company')
                        ->disabledClick()
                        ->searchable()
                        ->grow(false)
                        ->action(function ($livewire, $record) {
                            data_set(
                                $livewire->tableFilters,
                                'company_id.value',
                                $record->company_id,
                            );
                        }),
                    Tables\Columns\TextColumn::make('salary')
                        ->icon('heroicon-o-banknotes')
                        ->grow(false),
                    Tables\Columns\TextColumn::make('location')
                        ->icon('heroicon-o-map-pin')
                        ->grow(false),
                    Tables\Columns\TextColumn::make('published_at')
                        ->sortable()
                        ->grow(false)
                        ->label('Published Date')
                        ->icon('heroicon-o-clock')
                        ->tooltip(fn ($state) => $state)
                        ->formatStateUsing(fn ($state) => $state->diffForHumans(short: true))
                        ->action(function ($livewire, $state) {
                            data_set(
                                $livewire->tableFilters,
                                'published_at.from',
                                $state->toFormattedDateString(),
                            );
                        }),
                ]),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('applied_at')
                    ->nullable()
                    ->default(false)
                    ->label('applied?'),
                Tables\Filters\SelectFilter::make('company_id')
                    ->searchable()
                    ->label('Company')
                    ->relationship('company', 'name'),
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Published from')
                            ->native(false),
                        Forms\Components\DatePicker::make('until')
                            ->label('Published until')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['from'] ?? null) {
                            $indicators['from'] = 'Published from ' . Carbon::parse($data['from'])->toFormattedDateString();
                        }

                        if ($data['until'] ?? null) {
                            $indicators['until'] = 'Published until ' . Carbon::parse($data['until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn ($record) => $record->link)
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn ($record) => $record->applied_at)
                    ->label('Not Interested'),
                Tables\Actions\Action::make('apply job')
                    ->icon('heroicon-o-check-circle')
                    ->hidden(fn ($record) => $record->applied_at)
                    ->tooltip('Mark this job as applied')
                    ->action(function ($record) {
                        $record->touch('applied_at');
                        FilamentNotification::make()
                            ->title('Job applied!')
                            ->body('Wishing you infinite success!')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     //
                // ]),
            ])
            ->poll()
            ->paginated(false)
            ->defaultSort('published_at', 'desc');
    }

    public function render(): View
    {
        return view('livewire.job-item-resources.pages.list-job-items');
    }
}
