<div style="padding: 1rem" class="space-y-4">
    <x-filament::header :actions="[]" :breadcrumbs="[]" heading="My Statistics" subheading="" />
    @livewire(\App\Livewire\StatsOverview::class, ['lazy' => true])
</div>
