<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>LaraJobs Notifier</title>
    </head>
    <body class="antialiased bg-slate-800">
        <div class="divide-y divide-slate-700 text-slate-300 relative pt-12 overflow-scroll">
            <div class="flex items-center justify-center w-full absolute top-0 left-0 right-0 h-12">
                <a href="https://larajobs.com">
                <img src="/larajobs.svg" class="w-16" />
                </a>
            </div>

            @forelse($jobs as $job)
            <a href="{{ $job->link }}" target="_blank" class="p-4 block text-sm hover:bg-slate-900 space-y-2">
                <div class="flex space-x-4">
                    @if($job->has_icon)
                        <div class="w-12 h-12 aspect-square bg-center bg-cover" style="background-image:url({{$job->icon}})">
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <div class="inline-flex items-center space-x-2">
                            <b class="text-md font-black">{{ $job->title }}</b>
                            @if(!$job->seen)
                            <div class="w-2 h-2 animate-pulse rounded-full bg-red-300"></div>
                            @endif
                        </div>
                        <ul class="space-y-0.5 text-sm">
                            <li class="text-slate-400 font-semibold">
                                {{ $job->company }}
                            </li>
                            <li class="text-slate-400">
                                {{ $job->location }}
                            </li>
                            <li class="space-x-1 text-slate-400">
                                <span>{{ $job->type }}</span>
                                @if(!empty($job->salary))
                                <span>{{ $job->salary }}</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>

                @if(!empty($job->tags))
                <div class="inline-flex space-x-1">
                    @foreach(explode(',', $job->tags) as $tag)
                    <span class="py-1 px-2 text-slate-400 border border-slate-500 rounded-sm text-xs">
                        {{ $tag }}
                    </span>
                    @endforeach
                </div>
                @endif

                <p class="text-xs text-slate-500">
                    <span>{{ $job->pub_date->diffForHumans() }}</span>
                </p>
            </a>
            @empty
            <div class="p-2 block text-sm flex flex-col h-32 text-center justify-center">
                <span>Nothing to see here yet.</span>
            </div>
            @endforelse
        </div>
        <script>
            setInterval(function() {
                console.log('fetching jobs...');
                window.location.reload()
            }, 10 * 1000);
        </script>
    </body>
</html>
