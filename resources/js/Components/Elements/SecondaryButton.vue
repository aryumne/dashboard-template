<script setup>
defineProps({
    buttonType: {
        type: String,
        default: "button",
    },
    customClass: {
        type: String,
        default: "",
    },
    isOutline: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
     isLoading: {
        type: Boolean,
        default: false,
    }
});
</script>
<template>
     <button
        :type="buttonType"
        class="inline-flex h-full px-3 py-2 items-center border-2 rounded-md font-semibold text-xs capitalize tracking-wide focus:bg-accent active:bg-secondary/30 active:text-highlight focus:text-highlight focus:outline-none focus:ring-2 focus:ring-highlight focus:ring-offset-0 transition ease-in-out duration-150"
        :disabled="disabled"
        :class="[
            !isOutline
                ? 'bg-secondary text-white border-secondary hover:bg-secondary/70 hover:text-highlight hover:border-highlight hover:shadow-lg'
                : 'text-secondary border-secondary hover:bg-secondary hover:text-white',
            customClass,
            disabled || isLoading ? 'opacity-50': '',
            { 'cursor-pointer' : !disabled && !isLoading },
            { 'cursor-not-allowed' : disabled && !isLoading },
            { 'cursor-progress' : disabled && isLoading }]"
    >
        <slot v-if="!isLoading" />
        <div v-else class="flex items-center justify-center"> 
                                <div class="h-4 w-4 border-t-transparent border-solid animate-spin rounded-full border-primary border-2"></div>
                                <div class="ml-2"> Processing... </div>
                            </div>
    </button>
</template>
