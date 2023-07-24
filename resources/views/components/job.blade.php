<div class="border border-gray-200 rounded-md p-3 text-gray-800 space-y-1 truncate">
    <div class="overflow-hidden">
        <div class="text-sm">{{ $job->company }}</div>
        <div class="font-semibold truncate">{{ $job->title }}</div>
        <div class="text-sm text-gray-500 flex space-x-1 items-center truncate">
            <span>Added {{ $job->published_at->diffForHumans() }}</span>
            <span>&middot;</span>
            <span>
                {{ $job->location }}
            </span>
        </div>
    </div>

    <!-- <div class="flex items-center space-x-2 text-xs">
        @foreach ($job->tags as $tag)
            <div class="rounded-md px-2 py-1 border border-gray-100">{{ $tag->tag }}</div>
        @endforeach
    </div> -->
</div>