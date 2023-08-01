<div>
    <div class="bg-white/50 backdrop-blur absolute inset-0"></div>
    <div class="bg-white z-10 m-3 absolute inset-x-0 top-0 p-6 shadow-2xl rounded-lg">
        <button wire:click="$emit('cancelAddFilter')" class="absolute top-0 right-0 m-3 p-2 bg-gray-100 rounded-full text-lg font-bold block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="text-xl font-semibold text-gray-800">Add new filter</div>

        <p class="text-gray-500 text-sm">
            Customise which notifications you receive by adding a filter
        </p>

        <form wire:submit.prevent="submit" class="mt-6 space-y-3">
            <div>
                <label class="text-sm text-gray-500 mb-2">Field</label>
                <select wire:model="field" class="border border-gray-300 rounded-md w-full p-2">
                    <option>-- Select a field --</option>
                    <option value="{{ App\Enums\FilterField::Title }}">Title</option>
                    <option value="{{ App\Enums\FilterField::Location }}">Location</option>
                    <option value="{{ App\Enums\FilterField::Company }}">Company</option>
                </select>

                @error('field') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-sm text-gray-500 mb-2">Operation</label>
                <select wire:model="operation" class="border border-gray-300 rounded-md w-full p-2">
                    <option>-- Select an operation --</option>
                    <option value="{{ App\Enums\FilterOperation::Equals }}">equals</option>
                    <option value="{{ App\Enums\FilterOperation::NotEquals }}">is not</option>
                    <option value="{{ App\Enums\FilterOperation::Contains }}">contains</option>
                    <option value="{{ App\Enums\FilterOperation::NotContains }}">doesnt contain</option>
                </select>

                @error('operation') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-sm text-gray-500 mb-2">Query</label>
                <input wire:model="query" type="text" class="border border-gray-300 rounded-md w-full p-2"/>

                @error('query') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <button type="submit" class="bg-primary text-white font-medium rounded-lg w-full p-3">
                    Add filter
                </button>
            </div>
        </div>
    </div>
</div>