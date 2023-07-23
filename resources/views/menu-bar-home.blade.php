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
    <div class="w-[400px] h-[400px] bg-white overflow-hidden relative flex">
        <header
            class="flex items-end h-12 pb-2 px-8 flex-grow-0 bg-zinc-100/90 absolute top-0 left-0 right-0 backdrop-blur-sm border-b">
            <img src="/logo.svg" alt="LaraJobs Desktop" class="h-6">
            <nav class="flex text-sm ml-auto mb-1">
                <a onclick="shell.openExternal('{{ config('larajobs.website.url') }}')" href="#">
                    <i data-lucide="external-link"
                        class="h-4 text-[rgba(48,188,237,1)] transition-transform hover:scale-110"></i>
                </a>
            </nav>
        </header>
        <div class="px-4 pt-16 overflow-y-scroll">
            <main class="space-y-2">
                @foreach ($jobs as $job)
                    @php
                        extract($job->toArray());
                    @endphp
                    <a onclick="shell.openExternal('{{ $url }}')" href="#" class="block">
                        <section class="border border-gray-200 hover:border-zinc-400 px-4 py-2 rounded shadow-sm">
                            <h2 class="text-sm">{{ $creator }}</h2>
                            <h1 class="text-lg font-semibold">{{ $title }}</h1>
                        </section>
                    </a>
                @endforeach
            </main>
            <footer class="py-4 text-xs text-center text-zinc-400">
                <p>
                    Built by <a href="https://userscape.com"
                        class="text-[#044BD9] decoration-1 hover:underline">UserScape</a>
                    in
                    partnership with <a href="https://laravel-news.com"
                        class="text-[rgba(255,45,32,1)] decoration-1 hover:underline">Laravel
                        News</a>
                </p>
                <p>&copy; 2023</p>
            </footer>
        </div>
    </div>
</body>

</html>
