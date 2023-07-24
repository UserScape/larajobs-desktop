<div>
    <div class="bg-white/50 backdrop-blur absolute inset-0"></div>
    <div class="bg-white z-10 m-3 absolute inset-x-0 top-0 p-6 shadow-2xl rounded-lg">
        <button wire:click="$emit('cancelAddFilter')" class="absolute top-0 right-0 m-3 w-6 h-6 bg-gray-100 rounded-full text-lg font-bold block">
            &times;
        </button>

        <div class="text-xl font-semibold text-gray-800">Add new filter</div>

        <p class="text-gray-500 text-sm">
            Customise which notifications you receive by adding a filter
        </p>

        <div class="mt-6 space-y-3">
            <div>
                <label class="text-sm text-gray-500 mb-2">Field</label>
                <select wire:model="filter.field" class="border border-gray-300 rounded-md w-full p-2">
                    <option value="">-- Select a field --</option>
                    <option value="{{ App\Enums\FilterField::Title }}">Title</option>
                    <option value="{{ App\Enums\FilterField::Location }}">Location</option>
                    <option value="{{ App\Enums\FilterField::Company }}">Company</option>
                </select>
            </div>
            <div>
                <label class="text-sm text-gray-500 mb-2">Operation</label>
                <select wire:model="filter.operation" class="border border-gray-300 rounded-md w-full p-2">
                    <option value="">-- Select an operation --</option>
                    <option value="{{ App\Enums\FilterOperation::Equals }}">equals</option>
                    <option value="{{ App\Enums\FilterOperation::NotEquals }}">is not</option>
                    <option value="{{ App\Enums\FilterOperation::Contains }}">contains</option>
                    <option value="{{ App\Enums\FilterOperation::NotContains }}">doesnt contain</option>
                </select>
            </div>
            <div>
                <label class="text-sm text-gray-500 mb-2">Query</label>
                <input wire:model="filter.query" type="text" class="border border-gray-300 rounded-md w-full p-2"/>
            </div>
            <div>
                <button wire:click="addFilter" class="bg-primary text-white font-medium rounded-lg w-full p-3">
                    Add filter
                </button>
            </div>
        </div>
    </div>
</div>