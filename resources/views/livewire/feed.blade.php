<div>
    <header class="border-b border-gray-200 bg-white p-6 mb-4 sticky top-0"
         style="background-image: url('/img/bg-lara2.svg');
                background-repeat: no-repeat;
                background-size: auto 100%;
                background-position: center center;"
    >
        <div class="-ml-4 flex flex-wrap items-center justify-center sm:flex-nowrap">
            <div class="mt-2">
                <a onclick="shell.openExternal('https://larajobs.com')" href="#">
                    <img src="img/larajobs.png" class="h-8 w-auto" alt="larajobs.com"/>
                </a>
            </div>
        </div>
    </header>

    <div class="overflow-y-scroll overflow-hidden border-b border-sky-200 pb-10 " style="max-height: 500px;">
        @foreach ($feed->get_items() as $item)
            <livewire:job
                :wire:key="$item->get_id()"
                :location="$item->get_item_tags('https://larajobs.com','location')[0]['data']"
                :salary="$item->get_item_tags('https://larajobs.com','salary')[0]['data']"
                :job_type="$item->get_item_tags('https://larajobs.com','job_type')[0]['data']"
                :company_logo="$item->get_item_tags('https://larajobs.com','company_logo')[0]['data']"
                :tags="explode(',', $item->get_item_tags('https://larajobs.com','tags')[0]['data'])"
                :author="$item->get_author()->name"
                :link="$item->get_permalink()"
                :title="$item->get_title()"
                :description="$item->get_description()"
                :date="$item->get_date()"
            />
        @endforeach
    </div>
    <p class="text-center text-sm text-sky-300 font-medium my-8">&copy; {{now()->year}} Larajobs.com. All Rights Reserved</p>
</div>
