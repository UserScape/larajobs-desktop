<div class="space-y-6 divide-y divide-gray-100">
    <div class="space-y-3">
        <h2 class="text-xs font-medium uppercase text-gray-500">For you</h2>
        <div class="space-y-3">
            @foreach ($forYouJobs as $job)
                <x-job :job="$job" />
            @endforeach
        </div>
    </div>
</div>
