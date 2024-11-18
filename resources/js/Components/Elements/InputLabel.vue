<script setup>
defineProps({
    value: {
        type: String,
    },
    isRequired: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <label class="block capitalize font-semibold text-xs text-secondary">
        <span v-if="value">{{ value }} </span>
        <strong v-if="isRequired" class="text-red-500"> *</strong>
        <span v-else><slot /></span>
    </label>
</template>
