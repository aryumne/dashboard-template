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
        class="inline-flex h-full px-3 py-2 items-center border-2 rounded-md font-semibold text-xs capitalize tracking-wide focus:bg-accent active:bg-accent active:text-red-600 focus:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-0 transition ease-in-out duration-150"
        :disabled="disabled"
        :class="[
            !isOutline
                ? 'bg-red-600 text-white border-transparent hover:bg-transparent hover:text-red-600 hover:border-red-600'
                : 'text-red-600 border-red-600 hover:bg-red-600 hover:text-white',
            customClass,
            disabled || isLoading ? 'opacity-50': '',
            { 'cursor-pointer' : !disabled && !isLoading },
            { 'cursor-not-allowed' : disabled && !isLoading },
            { 'cursor-progress' : disabled && isLoading },
            ]"
    >
        <slot v-if="!isLoading" />
        <div v-else class="flex items-center justify-center"> 
                                <div class="h-4 w-4 border-t-transparent border-solid animate-spin rounded-full border-red-600 border-2"></div>
                                <div class="ml-2"> Processing... </div>
                            </div>
    </button>
</template>
