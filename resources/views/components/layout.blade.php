<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name ')}}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <script>
            const shell = require('electron').shell;
        </script>
    </head>
    <body class="antialiased">
        <div class="bg-white">
            <x-header/>

            <main>
                {{ $slot }}
            </main>

            <x-footer/>
        </div>
        @livewireScripts
    </body>
</html>
