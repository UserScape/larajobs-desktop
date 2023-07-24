<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LaraJobs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        const shell = require('electron').shell;
    </script>
</head>

<body class="antialiased bg-transparent bg-slate-100" style="background-image: radial-gradient(circle at center center, transparent,rgb(255,255,255)),linear-gradient(309deg, rgba(90, 90, 90,0.05) 0%, rgba(90, 90, 90,0.05) 50%,rgba(206, 206, 206,0.05) 50%, rgba(206, 206, 206,0.05) 100%),linear-gradient(39deg, rgba(13, 13, 13,0.05) 0%, rgba(13, 13, 13,0.05) 50%,rgba(189, 189, 189,0.05) 50%, rgba(189, 189, 189,0.05) 100%),linear-gradient(144deg, rgba(249, 249, 249,0.05) 0%, rgba(249, 249, 249,0.05) 50%,rgba(111, 111, 111,0.05) 50%, rgba(111, 111, 111,0.05) 100%),linear-gradient(166deg, rgba(231, 231, 231,0.05) 0%, rgba(231, 231, 231,0.05) 50%,rgba(220, 220, 220,0.05) 50%, rgba(220, 220, 220,0.05) 100%),linear-gradient(212deg, rgba(80, 80, 80,0.05) 0%, rgba(80, 80, 80,0.05) 50%,rgba(243, 243, 243,0.05) 50%, rgba(243, 243, 243,0.05) 100%),radial-gradient(circle at center center, hsl(107,19%,100%),hsl(107,19%,100%));">
    <div class="p-4">
        <div class="flex items-center justify-between">
            <h1 class="font-bold mb-3 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                  </svg>

                <span>Latest Jobs</span>
            </h1>
        </div>
        <div class="space-y-2">
            @foreach ($jobs as $job)
                <a href="#" onclick="shell.openExternal('{{ $job['link'] }}')" class="relative w-full bg-white rounded border border-gray-50 hover:bg-white hover:border-black block group overflow-hidden shadow-sm hover:shadow-lg transition-all">
                    <span class="absolute right-0 -top-5 text-[10px] px-1 py-px bg-black text-white font-bold rounded-t-r rounded-bl-lg group-hover:-top-0 transition-all">{{ $job['job_salary'] != "" ? $job['job_salary'] : "?" }}</span>
                    <div class="relative p-3 flex items-center gap-3">
                        <div class="w-12 aspect-square relative overflow-hidden shrink-0">
                            <div class="w-12 bg-black rounded aspect-square flex items-center justify-center absolute inset-0 -left-12 group-hover:-left-0 transition-all z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                                    <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <img src="{{ $job['job_company_logo'] }}" onerror="this.onerror=null;this.src='/img/nologo.png';" class="w-12 aspect-square object-contain group-hover:scale-50 transition-all" alt="" />
                        </div>
                        <div>
                            <p class="text-xs text-black/50">{{ $job['job_company'] }}</p>
                            <h2 class="line-clamp-1 text-sm font-bold">{{ $job['title'] }}</h2>
                            <p class="text-xs text-black/50">{{ Str::title(Str::replace("_", " ", $job['job_type'])) }} &CircleDot; {{ $job['job_location'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <p class="text-xs mb-1 text-black/50">Find more at:</p>
            <a href="#" onclick="shell.openExternal('https://larajobs.com')">
                <img src="/img/larajobs.svg" alt="LaraJobs" class="h-5 mx-auto" />
            </a>
        </div>
    </div>
</body>

</html>
