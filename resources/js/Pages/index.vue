<script setup>
import Job from '../Components/Job.vue';
import { usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

// create an example jobs array
const jobs = usePage().props.jobs;

// todo: maybe replace this with some state
const updated  = ref(
    new URLSearchParams(window.location.href.split('?')[1]).get('watchUpdated')
);
setTimeout(() => {
    updated.value = false
    window.history.pushState(null, null, '/')
}, 2000);
</script>


<template>
    <div v-if="updated" class="bg-larajobs-400 p-4 rounded w-full text-white font-bold">
        <p>Search Params Updated!</p>
    </div>
    <Job v-for="(job, key) in jobs" v-bind="job" :key="key"/>
</template>
