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
    errorMessage: {
        type: String,
        default: "",
    },
});

const modelValue = defineModel({
  prop: 'modelValue',
  event: 'update:modelValue',
  default: ''
});

</script>
<template>
    <div>
        <div class="flex items-center space-x-2">
            <InputLabel class="flex-none" :for="id" :value="label" :is-required="isRequired" />
            <div class="grow">
                <FormInput
            :id="id"
            :type="type"
            class="w-full"
            v-model="modelValue"
            :required="isRequired"
            />
            </div>
        </div>
        <InputError class="mt-2" :message="errorMessage" />
    </div>
</template>
