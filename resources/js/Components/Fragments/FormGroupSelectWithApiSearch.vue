<script setup>
import InputLabel from "@/Components/Elements/InputLabel.vue";
import InputError from "@/Components/Elements/InputError.vue";
import SelectInputWithApiSearch from "@/Components/Elements/SelectInputWithApiSearch.vue";
defineProps({
    id: {
        type: String,
        default: "select",
    },
    showLabel: {
        type: Boolean,
        default: true,
    },
    routeName: {
        type: String,
        required: true,
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
    modelValue: [String, Number],
    errorMessage: {
        type: String,
        default: "",
    },
    placeholder: {
        type: String,
        default: "Choose ...",
    },
    isDisabled: {
        type: Boolean,
        default: false,
    },
});

const modelValue = defineModel({
    prop: "modelValue",
    event: "update:modelValue",
    default: "",
});
</script>
<template>
    <div>
        <InputLabel v-if="showLabel" :for="id" :value="label" :is-required="isRequired" />
        <SelectInputWithApiSearch :id="id" class="mt-1 block w-full" :route-name="routeName" :class="{ 'bg-boxc': setBgColor }"
            v-model="modelValue" :placeholder="placeholder" :is-disabled="isDisabled">
            <slot />
        </SelectInputWithApiSearch>
        <InputError class="mt-2" :message="errorMessage" />
    </div>
</template>
