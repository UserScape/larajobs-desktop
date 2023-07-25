<script setup>
import Multiselect from 'vue-multiselect'
import { reactive } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

const page = usePage()
const defaultTags = [
    'Laravel', 'Contract', 'Engineer', 'Livewire', 'VueJS', 'Backend', 'Fullstack', 'SaaS',
    'AlpineJS', 'AWS', 'Bootstrap', 'MySQL', 'PHP', 'API', 'TailwindCSS', 'JavaScript', 'Linux',
    'TALL Stack', 'Node.js', 'Redis', 'React', 'LAMP', 'Git', 'SQL', 'Frontend', 'Analyst', 'Cloud',
    'Angular', 'Lead', 'Full Time', 'Senior', 'Postgres'
]

const watching = reactive(page.props.watching);

const availableTags = [
    ...defaultTags, ...watching?.tags ?? []
].filter((value, index, self) => {
    return self.indexOf(value) === index;
});

const addTag = (tag) => watching.tags.push(tag)

const save = () => {
    fetch('/watching', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

        },
        body: JSON.stringify(watching)
    }).then(() => {
        router.get('/', { watchUpdated: true });
    })
}

</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>
    <div class="flex flex-col gap-2 h-full">
        <div class="flex flex-col gap-2">
            <label class="text-lg flex flex-col gap-1">
                <strong>Select Tags to Filter By</strong>
                <span class="text-sm text-gray-500">
                    Tags you want to filter by (Leave blank for all)
                </span>
            </label>
            <Multiselect :value="null" :options="availableTags" v-model="watching.tags" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
        </div>
        <div class="flex flex-col gap-2">
            <label class="text-lg flex flex-col gap-1">
                <strong>Minimum Hourly Rate</strong>
                <span class="text-sm text-gray-500">
                    Minimum hourly rate you want to filter by (Leave blank for all). This will be converted to an yearly rate or monthly rate depending on the job posting.
                </span>
            </label>
            <div class="grid grid-cols-12">
                <!-- Currency Selection-->
                <select class="border border-gray-300 rounded-md p-2 col-span-2 md:text-xl text-center" v-model="watching.salary.currency">
                    <option value="USD">$</option>
                    <option value="EUR">€</option>
                    <option value="GBP">£</option>
                </select>
                <input class="border border-gray-300 rounded-md p-2 col-span-10" type="number" placeholder="Minimum Salary" v-model="watching.salary.min"/>
            </div>
        </div>
        <div class="flex flex-col gap-2">
            <label class="text-lg flex flex-col gap-1">
                <div class="flex gap-2 items-center">
                    <strong>Full Time</strong>
                    <input v-model="watching.full_time" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                </div>
                <span class="text-sm text-gray-500">
                    Filter by full time jobs.
                </span>
            </label>
        </div>
        <div class="flex flex-col gap-2 mt-auto">
            <a href="#" @click="save">
                <button class="bg-larajobs-400 text-white rounded-md p-2 w-full active:bg-larajobs-600">Save</button>
            </a>
            <a href="/">
                <button class="bg-[#f87371] text-white rounded-md p-2 w-full active:bg-[#dc2926]">Cancel</button>
            </a>
        </div>
    </div>
</template>
