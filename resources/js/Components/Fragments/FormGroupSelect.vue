<script setup>
import InputLabel from "@/Components/Elements/InputLabel.vue";
import InputError from "@/Components/Elements/InputError.vue";
import SelectInput from "@/Components/Elements/SelectInput.vue";
defineProps({
    id: {
        type: String,
        default: "select",
    },
    showLabel: {
        type: Boolean,
        default: true,
    },
    setBgColor: {
        type: Boolean,
        default: false,
    },
    label: {
        type: String,
        required: true,
    },
    isRequired: {
        type: Boolean,
        default: false,
    },
    options: {
        type: Array,
        required: true,
    },
    modelValue: [String, Number],
    errorMessage: {
        type: String,
        default: "",
    },
    isLoading: {
        type: Boolean,
        default: false,
    },
    withSearch: {
        type: Boolean,
        default: true,
    },
    placeholder: {
        type: String,
        default: "Choose ...",
    },
    withMarker: {
        type: Boolean,
        default: false,
    },
    isDisabled: {
        type: Boolean,
        default: false,
    }
});

const modelValue = defineModel({
    prop: "modelValue",
    event: "update:modelValue",
    default: "",
});
</script>
<template>
    <div>
        <InputLabel
            v-if="showLabel"
            :for="id"
            :value="label"
            :is-required="isRequired"
        />
        <SelectInput
            :id="id"
            class="mt-1 block w-full"
            :class="{ 'bg-boxc': setBgColor }"
            v-model="modelValue"
            :options="options"
            :placeholder="placeholder"
            :with-search="withSearch"
            :with-marker="withMarker"
            :is-loading="isLoading"
            :is-disabled="isDisabled"
        >
            <slot />
        </SelectInput>
        <InputError class="mt-2" :message="errorMessage" />
    </div>
</template>
