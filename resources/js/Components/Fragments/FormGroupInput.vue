<script setup>
import InputLabel from "@/Components/Elements/InputLabel.vue";
import InputError from "@/Components/Elements/InputError.vue";
import FormInput from "@/Components/Elements/FormInput.vue";
defineProps({
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: "text",
    },
    modelValue: [String, Number],
    isRequired: {
        type: Boolean,
        default: false,
    },
    isDisabled: {
        type: Boolean,
        default: false,
    },
    errorMessage: {
        type: String,
        default: "",
    },
    isDecimal: {
        type: Boolean,
        default: false,
    },
    placeholder: {
        type: String,
        default: "type here"
    }
});

const modelValue = defineModel({
  prop: 'modelValue',
  event: 'update:modelValue',
  default: ''
});

</script>
<template>
    <div>
        <InputLabel :for="id" :value="label" :is-required="isRequired" />
        <FormInput
            :id="id"
            :type="type"
            class="mt-1 block w-full"
            v-model="modelValue"
            :is-required="isRequired"
            :is-disabled="isDisabled"
            :is-decimal="isDecimal"
            :placeholder="placeholder"
        />
        <InputError class="mt-2" :message="errorMessage" />
    </div>
</template>
