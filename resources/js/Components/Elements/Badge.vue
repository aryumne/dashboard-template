<script setup>
import { computed } from "vue";

const props = defineProps({
    type: {
        type: String,
        default: "info",
    },
    text: {
        type: String,
        required: true,
    },
});

const badgeColor = computed(() => {
    return {
        info: "bg-blue-200",
        secondary: "bg-gray-200",
        warning: "bg-yellow-200",
        error: "bg-red-200",
        success: "bg-green-200",
        primary: "bg-primary",
        outlinePrimary: "bg-bgc-2",
    }[props.type];
});
const textColor = computed(() => {
    return {
        info: "text-blue-900",
        secondary: "text-gray-900",
        warning: "text-yellow-900",
        error: "text-red-900",
        success: "text-green-900",
        primary: 'text-white',
        outlinePrimary: 'text-primary',
    }[props.type];
});
</script>

<template>
    <span
        class="relative inline-block px-2 py-1 font-medium leading-none tracking-wide hover:opacity-70"
    >
        <span
            aria-hidden
            class="absolute inset-0 rounded-full"
            :class="badgeColor"
        ></span>
        <span class="relative text-xs" :class="textColor">{{
            props.text
        }}</span>
    </span>
</template>
