<script setup>
const { text } = defineProps({
    text: String,
})
</script>

<template>
    <div class="text-sm border text-gray-700 border-gray-400 px-1 py-0 md:px-2 rounded self-center whitespace-no-wrap">
        {{ text }}
    </div>
</template>
