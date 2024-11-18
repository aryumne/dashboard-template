<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>
<template>
    <div class="py-1 mb-2 flex flex-row items-center space-x-2">
        <div>
            <h1 class="font-bold uppercase md:text-lg text-primary">
                {{ title }}
            </h1>
        </div>
        <slot />
    </div>
</template>
