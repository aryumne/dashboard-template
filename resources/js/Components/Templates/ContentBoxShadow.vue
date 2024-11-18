<script setup>
defineProps({
    customClass: {
        type: [String, Object, Array],
        required: false,
    },
    title: {
        type: String,
        required: false,
    },
    overflowHidden: {
        type: Boolean,
        default: true,
    }
});
</script>
<template>
    <div
        class="flex flex-col flex-1 bg-boxc shadow p-4"
        :class="[overflowHidden && 'overflow-hidden', customClass]"
    >
        <div class="flex justify-between" v-if="title">
            <h2 class="font-semibold capitalize text-highlight">
                {{ title }}
            </h2>
            <slot name="top-right-button" />
        </div>
        <slot />
    </div>
</template>
