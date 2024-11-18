<script setup>
import InputLabel from "@/Components/Elements/InputLabel.vue";

defineProps({
    label: String,
    options: {
        type: Array,
        required: true,
        default: () => [
            { label: "First", value: "first" },
            { label: "Second", value: "second" },
            { label: "Third", value: "third" },
        ],
    },
    isRequired: {
        type: Boolean,
        default: false,
    },
    isVertical: {
        type: Boolean,
        default: true,
    },
    withLabel: {
        type: Boolean,
        default: true,
    }
});
const model = defineModel({ type: String, default: "" });
</script>
<template>
    <div>
    <InputLabel v-if="withLabel" :for="id" :value="label" :is-required="isRequired" class="mb-3" />
        <div
            class="flex"
            :class="isVertical ? 'flex-col space-y-2' : 'space-x-4'"
        >
            <div v-for="(option, index) in options">
                <div class="flex items-center pl-2">
                    <input
                        type="radio"
                        :id="'radio-' + index"
                        :value="option.value"
                        v-model="model"
                        class="form-radio h-4 w-4 text-primary border border-gray-300 transition duration-150 ease-in-out"
                    />
                    <label
                        :for="'radio-' + index"
                        class="ml-3 block text-sm font-semibold text-contentc"
                    >
                        {{ option.label }}
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>
