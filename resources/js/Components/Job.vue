<script setup>
import Tag from './Tag.vue';
import { Icon } from '@iconify/vue';

const { location, title, type, salary, date } = defineProps({
    title: String,
    creator: String,
    location: String,
    job_type: String,
    salary: String,
    company: String,
    company_logo: String,
    tags: Array,
    guid: String,
})

</script>

<template>
    <a :href="guid" target="_blank">
        <div class="flex items-center hover:bg-purple-200 transition-all rounded cursor-pointer text-black p-2 ">
            <div class="w-full truncate">
                <p class="text-sm tex-gray-400">{{ company }}</p>
                <div class="flex flex-col md:gap-2 gap-0 md:flex-row  justify-between">
                    <p class="text-xl font-bold overflow-clip">{{ title }}</p>
                    <div class="justify-self-end text-sm">
                        <div class="flex items-center gap-4 text-gray-400">
                            <div class="flex gap-1 items-center">
                                <Icon icon="ph:globe" />
                                <p>{{ location }}</p>
                            </div>

                            <div class="flex gap-1 items-center">
                                <Icon icon="mdi:calendar-week" />
                                <p>{{ date }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-2 md:gap-0 md:flex-row justify-between">
                    <div class="text-sm flex flex-row gap-2 items-center justify-center">
                        <p>{{ job_type === 'FULL_TIME' ? 'Full Time' : 'Part Time' }}</p>
                        <p v-if="salary?.currency"> - </p>
                        <template v-if="salary?.currency"> {{ salary.raw }} </template>
                    </div>
                    <div class="flex gap-2" v-if="tags">
                        <!-- Only take the first 4 tags -->
                        <Tag v-for="(tag, key) in tags.slice(0,4)" :key="key" :text="tag" />
                    </div>
                </div>
            </div>
        </div>
    </a>
</template>
