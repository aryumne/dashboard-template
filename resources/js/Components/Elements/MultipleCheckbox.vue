<script setup>
defineProps({
    label: {
        type: String,
        required: false,
    },
    modelValue: {
        type: Array,
        default: () => [],
    },
    options: {
        type: Array,
        required: true,
        default: () => [
            { label: "First", value: "first" },
            { label: "Second", value: "second" },
            { label: "Third", value: "third" },
        ],
    },
});

const model = defineModel({ default: [] });
</script>
<template>
    <div>
        <p v-if="label" class="font-semibold mb-4 text-secondary uppercase text-xs">
            {{ label }}
        </p>
        <div
            v-for="(option, index) in options"
            :key="index"
            class="flex items-center mb-2 pl-2"
        >
            <input
                type="checkbox"
                :id="'checkbox-' + index"
                :value="option.value"
                v-model="model"
                class="form-checkbox h-4 w-4 text-primary rounded-md border border-gray-300 transition duration-150 ease-in-out"
            />
            <label
                :for="'checkbox-' + index"
                class="ml-3 block text-sm font-semibold text-contentc"
            >
                {{ option.label }}
            </label>
        </div>
    </div>
</template>
