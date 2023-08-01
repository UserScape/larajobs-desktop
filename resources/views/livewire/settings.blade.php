<div class="space-y-6 p-6">
    <section class="space-y-3">
        <p class="text-sm mt-2">
            Optionally customise which notifications you receive by adding filters.
        </p>

        <ul class="divide-y divide-gray-200">
            @forelse ($filters as $i => $filter)
                <li class="text-sm py-3 relative">
                    @if ($i > 0)
                        <span class="text-gray-500 absolute -top-2 bg-white px-2 mx-2 uppercase text-xs">or</span>
                    @endif

                    <div class="flex w-full justify-between">
                        <div>
                            <x-filter :filter="$filter"/>
                        </div>
                        <button wire:click="deleteFilter({{ $filter }})" class="text-red-400 hover:text-red-500" title="Remove filter">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </li>
            @empty
                <li class="text-sm text-gray-500">
                    You haven't added any filters, so we'll notify you of all new jobs posted.
                </li>
            @endforelse
        </ul>

        <button wire:click="$set('addNewFilter', true)" class="border border-primary text-primary rounded-lg justify-center w-full p-3 font-medium flex space-x-1 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            <span>Add {{$filters->isNotEmpty() ? 'another ' : '' }}filter</span>
        </button>
    </section>

    @if ($addNewFilter)
        <livewire:new-filter/>
    @endif
</div>