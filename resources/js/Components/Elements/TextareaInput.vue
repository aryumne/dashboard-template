<script setup>
defineProps({
    rows: {
        type: Number,
        default: 3,
    },
    modelValue: [String, Number],
    isDisabled: {
        type: Boolean,
        default: false
    },
    isRequired: {
        type: Boolean,
        default: false
    },
    isDisabled: {
        type: Boolean,
        default: false
    },
});
const modelValue = defineModel({
  prop: 'modelValue',
  event: 'update:modelValue',
  default: ''
});
</script>

<template>
    <textarea type="text" :rows="rows"
        class="mt-1 text-xs text-contentc bg-transparent block w-full p-2 border border-gray-400 focus:border-primary focus:ring-primary rounded-md shadow-sm"
        :class="[isDisabled? 'cursor-not-allowed': 'cursor-text']"
        v-model="modelValue" :required="isRequired" :disabled="isDisabled"></textarea>
</template>
