<script setup>
defineProps({
    textAlign: {
        type: String,
        default: "text-left",
    },
    isLast: {
        type: Boolean,
        default: false,
    },
    customClass: {
        type: String,
        default: "",
    },
    noWrap: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <td
        class="px-2 text-xs leading-normal"
        :class="[
            !isLast
                ? 'border-r border-r-neutral-300 dark:border-neutral-600'
                : '',
            customClass,
            noWrap ? 'whitespace-nowrap' : 'whitespace-normal',
        ]"
    >
        <div class="flex justify-center">
            <div class="w-full text-contentc" :class="[textAlign]">
                <slot />
            </div>
        </div>
    </td>
</template>
