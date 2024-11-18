<script setup>
defineProps({
    customClass: {
        type: String,
        default: "",
    },
    isActive: {
        type: Boolean,
        default: false
    },
    isFirst: {
        type: Boolean,
        default: false
    },
    isLast: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <button
        type="button"
        class="inline-flex bg-boxc h-full items-center rounded-t px-4 py-2 text-sm border-b-2 font-semibold tracking-normal focus:outline-none focus:ring-2 focus:ring-transparent focus:ring-offset-0 transition ease-in-out duration-150 hover:text-primary hover:border-b-2 hover:border-b-primary"
        :class="[isActive ? ' border-b-primary text-primary' : ' border-b-transparent text-secondary',
            isFirst && 'rounded-tl', isLast && 'rounded-tr'
        ]"
    >
        <slot />
    </button>
</template>
