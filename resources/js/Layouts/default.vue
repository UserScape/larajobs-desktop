<script setup>
import { Icon } from '@iconify/vue';
</script>


<template>
    <div class="flex h-[100vh] flex-col md:p-4 py-4 p-2">
        <div class="flex justify-between items-center">
            <div class="flex justify-center flex-grow">
                <img src="https://larajobs.com/img/logo.svg" class="h-[35px] mx-auto" />
            </div>
            <div>
                <a href="/watching">
                    <Icon class="text-2xl hover:text-gray-500 cursor-pointer transition-colors" icon="ic:baseline-notifications" />
                </a>
            </div>
        </div>
        <div class="flex h-[90vh] flex-col gap-2 overflow-y-scroll py-5">
           <slot />
        </div>
    </div>
</template>
