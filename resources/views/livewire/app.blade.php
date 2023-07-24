<div>
    <livewire:header />
    <div class="p-3">
        @if ($showSettings)
            <livewire:settings />
        @else
            <x-content-view
                :forYouJobs="$jobs"
            />
        @endif

    </div>
</div>
