@php
    use Illuminate\Support\Carbon;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaraJobs Desktop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        const shell = require('electron').shell;
    </script>
</head>

<body class="antialiased">
    <div
        class="w-[{{ config('larajobs.ui.menu-bar.view.width') }}px] h-[{{ config('larajobs.ui.menu-bar.view.height') }}px] bg-white overflow-hidden relative flex">
        <header
            class="z-10 flex items-end h-12 pb-2 pl-8 pr-4 flex-grow-0 bg-zinc-100/90 absolute top-0 left-0 right-0 backdrop-blur-sm border-b">
            <img src="/logo.svg" alt="LaraJobs Desktop" class="h-6">
            <nav class="flex text-sm ml-auto mb-1 space-x-2">
                <a onclick="shell.openExternal('larajobs://refresh')" href="#">
                    <x-lucide-refresh-ccw class="h-4 text-[rgba(48,188,237,1)] transition-transform hover:scale-110" />
                </a>
                <a onclick="shell.openExternal('{{ config('larajobs.website.url') }}')" href="#">
                    <x-lucide-external-link
                        class="h-4 text-[rgba(48,188,237,1)] transition-transform hover:scale-110" />
                </a>
            </nav>
        </header>
        <div class="px-4 pt-16 overflow-y-scroll w-full">
            <main class="space-y-2">
                @foreach ($jobs as $job)
                    @php
                        extract($job->toArray());
                    @endphp
                    <a onclick="shell.openExternal('{{ $url }}')" href="#"
                        class="block relative h-20 ml-4">
                        <div
                            class="absolute inset-0 border border-gray-200 hover:border-zinc-400 py-2 rounded shadow-sm pl-10 pr-4">
                            <h2 class="text-sm truncate">{!! $company !!}</h2>
                            <h1 class="font-medium truncate">{!! $title !!}</h1>
                            <div class="text-zinc-700 text-xs flex items-center gap-1">
                                @if ($fulltime)
                                    <span>Full Time</span>
                                @endif
                                @if ($salary)
                                    <span class="truncate flex-0 max-w-[128px]">{{ $salary }}</span>
                                @endif
                                <span class="ml-auto"></span>
                                @if ($location)
                                    <x-lucide-globe-2 class="h-3" />
                                    <span class="truncate flex-0 max-w-[128px]">{{ $location }}</span>
                                @endif
                                <x-lucide-calendar class="h-3" />
                                <span>{{ Carbon::parse($published_at)->diffForHumans(null, true, true) }}</span>
                            </div>
                        </div>
                        <div
                            class="w-12 h-12 bg-white shadow-lg rounded-full absolute -left-6 top-4 text-zinc-300 flex items-center justify-center">
                            @if ($logo)
                                <img class="object-contain h-7 rounded" src="{{ $logo }}" alt="" />
                            @else
                                <x-lucide-building />
                            @endif
                        </div>
                    </a>
                @endforeach
            </main>
            <footer class="py-4 text-xs text-center text-zinc-400">
                <p>&copy; 2023 &mdash;
                    Built by <a href="https://userscape.com"
                        class="text-[#044BD9] decoration-1 hover:underline">UserScape</a>
                    in
                    partnership with <a href="https://laravel-news.com"
                        class="text-[rgba(255,45,32,1)] decoration-1 hover:underline">Laravel
                        News</a>
                </p>
            </footer>
        </div>
    </div>
</body>

</html>
