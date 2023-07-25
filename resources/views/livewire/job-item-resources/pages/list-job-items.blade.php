<div x-init="setInterval(() => $wire.getFeeds(), 30000);" style="padding: 1rem" class="space-y-2">
    <div class="flex justify-between items-center">
        <div>
            <a href="https://larajobs.com" target="_blank">
                <img style="width: 8rem" src="https://larajobs.com/img/logo.svg" />
            </a>
            <p class="uppercase text-gray-600 select-none">desktop</p>
        </div>
        <a href="https://larajobs.com" target="_blank">
            <h4 style="font-size: 2.5rem">🚀</h4>
        </a>
    </div>
    <div>
        {{ $this->table }}
    </div>
</div>
