<x-layout>
    @foreach ($jobPosts as $post)
        @php
            $color = '#2d3748';
        @endphp
        {{-- <a data-url="https://www.bythepixel.com/laravel-vuejs-developer.html" href="/job/3090" class="job-link group block mb-6 px-6 md:px-0"> --}}
        <a onclick="shell.openExternal('{{ $post->link }}')" href="javascript:;" class="group block px-0 border-b border-gray-200 hover:bg-[#eee] transition-all">
            <div
                class="relative rounded p-4 shadow-sm flex items-center space-x-3 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
            >
                <div class="flex-shrink-0 mb-2">
                    @if ($post->company_logo)
                        <img class="h-10 w-10 rounded object-contain" src="{{ $post->company_logo }}">
                    @else
                        <img class="h-10 w-10 rounded object-contain" src="/images/nologo.svg">
                    @endif
                </div>

                <div class="flex flex-col md:flex-row w-full">
                    <div class="flex-1 min-w-0 mb-0 w-full" style="color:{{ $color }};">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-xs text-gray-500 truncate" style="color:{{ $color }};">{{ $post->creator->name }}</p>
                        <p class="text-md font-bold text-gray-900" style="color:{{ $color }};">{{ $post->title }}</p>
                        <p class="text-xs text-gray-500" style="color:{{ $color }};">
                            @if ($post->type === 'FULL_TIME')
                                Full Time
                            @elseif ($post->type)
                                {{ $post->type }}
                            @endif
                            @if ($post->salary)
                                <span class="text-gray-500" style="color:{{ $color }};">- {{ $post->salary }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex-none text-xs md:flex flex-col md:justify-end text-gray-500 md:px-2" style="color:{{ $color }};">
                        <div class="flex justify-between">
                            @if ($post->location)
                                <div class="flex items-center mr-4 mb-0 text-gray-500" style="color:{{ $color }};">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $post->location }}
                                </div>
                            @endif
                            <div class="flex items-center" style="color:{{ $color }};">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $post->published_at->diffForHumans(['short' => true]) }}
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-1 gap-2 md:justify-end mt-1">
                            @foreach ($post->tags as $tag)
                                <div class="border text-gray-700 border-gray-400 py-0 px-2 rounded self-center whitespace-no-wrap" style="color:{{ $color }};">
                                    {{ $tag->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</x-layout>