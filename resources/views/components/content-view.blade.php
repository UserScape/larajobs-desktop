<div class="space-y-6 divide-y divide-gray-100">
    <div class="space-y-3">
        <h2 class="text-xs font-medium uppercase text-gray-500">For you</h2>
        <div class="space-y-3">

        </div>
    </div>
</div>

<div class="overflow-y-scroll">
    <main>
        @foreach ($forYouJobs as $job)
            <x-job :job="$job" />
        @endforeach