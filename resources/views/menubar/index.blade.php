<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name ')}}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            const shell = require('electron').shell;
        </script>
    </head>

    <body class="antialiased">
        <div class="bg-white overflow-hidden relative">
            <header
                class="flex items-end h-12 pb-2 px-8 flex-grow-0 bg-[#f4f4f5]"
            >
                <a onclick="shell.openExternal('https://larajobs.com')" href="#">
                    <img src="/images/larajobs.svg" alt="{{ config('app.name ')}}" class="h-6">
                </a>
                {{-- <div class="">
                    <a href="https://larajobs.com/laravel-consultants" class="px-4 py-2 rounded-sm border-2 border-accent bg-sky-200 text-zinc-800 hover:bg-white hover:text-accent">Hire a Consultant</a>
                    <a href="https://larajobs.com/create" class="px-4 py-2 rounded-sm border-2 border-accent bg-accent text-white hover:bg-white hover:text-accent">Post a Job</a>
                </div> --}}
            </header>
            <div class="overflow-y-scroll">
                <main>
                    @foreach ($jobPosts as $post)
                        @php
                            extract($post);
                            $tags = [];
                            $color = '#2d3748';
                        @endphp
                        {{-- <a data-url="https://www.bythepixel.com/laravel-vuejs-developer.html" href="/job/3090" class="job-link group block mb-6 px-6 md:px-0"> --}}
                        <a onclick="shell.openExternal('{{ $url }}')" href="javascript:;" class="group block px-0 border-b border-gray-200 hover:border-gray-400 hover:bg-[#eee] transition">
                            <div
                                class="relative rounded p-4 shadow-sm flex items-center space-x-3 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                            >
                                <div class="flex-shrink-0 mb-2">
                                    @if ($company_logo)
                                        <img class="h-10 w-10 rounded object-contain" src="{{ $company_logo }}">
                                    @else
                                        <img class="h-10 w-10 rounded object-contain" src="/images/nologo.svg">
                                    @endif
                                </div>

                                <div class="flex flex-col md:flex-row w-full">
                                    <div class="flex-1 min-w-0 mb-0 w-full" style="color:{{ $color }};">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        <p class="text-xs text-gray-500 truncate" style="color:{{ $color }};">{{ $creator }}</p>
                                        <p class="text-lg font-bold text-gray-900" style="color:{{ $color }};">{{ $title}}</p>
                                        <p class="text-xs text-gray-500" style="color:{{ $color }};">
                                            @if ($type === 'FULL_TIME')
                                                Full Time
                                            @elseif ($type)
                                                {{ $type }}
                                            @endif
                                            @if ($salary)
                                                <span class="text-gray-500" style="color:{{ $color }};">- {{ $salary }}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="flex-none text-xs md:flex flex-col md:justify-end text-gray-500 md:px-2" style="color:{{ $color }};">
                                        <div class="flex justify-between">
                                            @if ($location)
                                                <div class="flex items-center mr-4 mb-0 text-gray-500" style="color:{{ $color }};">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $location }}
                                                </div>
                                            @endif
                                            <div class="flex items-center" style="color:{{ $color }};">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $published_at->diffForHumans(['short' => true]) }}
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-1 gap-2 md:justify-end mt-1">
                                            @foreach ($post['tags'] as $tag)
                                                <div class="border text-gray-700 border-gray-400 py-0 px-2 rounded self-center whitespace-no-wrap" style="color:{{ $color }};">
                                                    {{ $tag }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </main>
                <div class="max-w-7xl mx-auto pt-4 overflow-hidden px-6 lg:px-8 pb-4">
                    <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
                        <div class="px-5 py-2">
                            <a onclick="shell.openExternal('https://larajobs.com')" href="javascript:;" class="text-base text-gray-500 hover:text-gray-900"> Jobs </a>
                        </div>

                        <div class="px-5 py-2">
                            <a onclick="shell.openExternal('https://larajobs.com/laravel-consultants')" href="javascript:;" class="text-base text-gray-500 hover:text-gray-900">Consultants</a>
                        </div>

                        <div class="px-5 py-2">
                            <a onclick="shell.openExternal('mailto:larajobs@userscape.com')" href="javascript:;" class="text-base text-gray-500 hover:text-gray-900"> Contact </a>
                        </div>

                        <div class="px-5 py-2">
                            <a onclick="shell.openExternal('https://larajobs.com/feed')" href="javascript:;" class="text-base text-gray-500 hover:text-gray-900"> RSS </a>
                        </div>

                        <div class="px-5 py-2">
                            <a onclick="shell.openExternal('https://twitter.com/laraveljobs')" href="javascript:;" class="text-base text-gray-500 hover:text-gray-900"> Twitter </a>
                        </div>
                    </nav>
                    <p class="mt-4 text-center text-base text-gray-400">
                        Built by <a onclick="shell.openExternal('https://userscape.com')" href="javascript:;">UserScape</a> in partnership with <a onclick="shell.openExternal('https://laravel-news.com')" href="javascript:;">Laravel News</a>
                    </p>
                    <p class="mt-1 text-center text-base text-gray-400">&copy; 2014 - {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </body>
</html>
