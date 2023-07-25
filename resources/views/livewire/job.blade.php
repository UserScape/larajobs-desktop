<div class="grid grid-cols-1 gap-4 mt-2 px-3">
    <a onclick="shell.openExternal('{{$this->link}}')" href="#">
        <div
            class="relative flex items-center space-x-2 flex-1 items-center space-x-3 rounded-lg  bg-white p-2 border border-gray-200 hover:border-gray-400 transition-bg duration-300">
            <div class="flex-shrink-0 mb-2 md:mb-0 md:absolute rounded-full md:p-4 md:bg-white md:shadow-lg md:-left-9">
                <img src="{{$company_logo}}" class="w-10 rounded" alt="{{$author}}"/>
            </div>
            <div class="min-w-0 flex-1 flex items-start justify-between">
                <div class="w-7/8 pr-2">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="font-medium text-sm text-gray-500 ">{{$author}}</p>
                    <p class="font-medium text-gray-900 capitalize">{{\Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::lower($title))}}</p>
                    <div class="flex items-center text-sm text-gray-500 truncate">
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                             viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <p class="font-medium text-gray-600 capitalize">{{\Illuminate\Support\Str::replace('_', ' ', \Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::lower($job_type)))}}</p>
                        @if($salary)
                            <p class="font-medium text-gray-600 capitalize">&nbsp;- {{$salary}}</p>
                        @endif
                    </div>

                    <div class="flex items-center ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="font-medium text-gray-600 ">
                            {{\Carbon\Carbon::make($date)->diffInDays()}}d
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-1 md:gap-2 md:justify-end mt-2">
                        @foreach($tags as $tag)
                            <div
                                class="text-sm border text-gray-700 border-gray-400 px-1 py-0 md:px-2 rounded self-center whitespace-no-wrap">
                                {{$tag}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </a>

</div>
