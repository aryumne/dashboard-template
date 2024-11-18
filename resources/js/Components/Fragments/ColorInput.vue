<script setup>
import InputLabel from "@/Components/Elements/InputLabel.vue";
import TextInput from "@/Components/Elements/TextInput.vue";
import InputError from "@/Components/Elements/InputError.vue";
import { computed, onMounted, ref, watch } from "vue";
const props = defineProps({
    id: String,
    title: String,
    error: [String, undefined],
    modelValue: String,
});
const emits = defineEmits(["update:modelValue"]);

const redColor = ref("0");
const greenColor = ref("0");
const blueColor = ref("0");
const colorPicker = ref("rgb(0,0,0)");
const validateDigits = (e, inputRef) => {
    let value = e.target.value;
    if (value.length > 3) value = value.slice(0, 3);
    if (parseInt(value) > 255) value = 255;
    if (parseInt(value) < 0) value = 0;

    if (inputRef === "redColor") redColor.value = value;
    if (inputRef === "greenColor") greenColor.value = value;
    if (inputRef === "blueColor") blueColor.value = value;
};

watch(
    () => colorPicker.value,
    (newVal) => {
        const rgbArray = newVal.match(/\d+/g);
        if (rgbArray && rgbArray.length === 3) {
            redColor.value = rgbArray[0];
            greenColor.value = rgbArray[1];
            blueColor.value = rgbArray[2];
        }
    }
);

watch(
    () => [redColor.value, greenColor.value, blueColor.value],
    ([newRedVal, newGreenVal, newBlueVal]) => {
        colorPicker.value = `rgb(${newRedVal}, ${newGreenVal}, ${newBlueVal})`;
        emits(
            "update:modelValue",
            `${redColor.value} ${greenColor.value} ${blueColor.value}`
        );
    }
);
onMounted(() => {
    const rgbArray = props.modelValue.split(" ");
    if (rgbArray && rgbArray.length === 3) {
        redColor.value = rgbArray[0];
        greenColor.value = rgbArray[1];
        blueColor.value = rgbArray[2];
    }
});
</script>

<template>
    <InputLabel :for="id" :value="title" />
    <div class="mt-1 flex space-x-3">
        <div class="basis-3/4 w-full flex space-x-1 md:space-x-2 lg:space-x-3">
            <TextInput
                :id="id"
                type="number"
                max="255"
                min="0"
                @input="validateDigits($event, 'redColor')"
                class="basis-1/3 block"
                :is-small="true"
                v-model="redColor"
                required
            />
            <TextInput
                :id="id"
                type="number"
                max="255"
                min="0"
                @input="validateDigits($event, 'greenColor')"
                class="basis-1/3 block"
                :is-small="true"
                v-model="greenColor"
                required
            />
            <TextInput
                :id="id"
                type="number"
                max="255"
                min="0"
                @input="validateDigits($event, 'blueColor')"
                class="basis-1/3 block"
                :is-small="true"
                v-model="blueColor"
                required
            />
        </div>
        <div class="basis-1/4 flex w-full justify-center items-center">
            <ColorPicker
                format="rgb"
                shape="square"
                v-model:pureColor="colorPicker"
            />
        </div>
    </div>
    <InputError class="mt-2" :message="error" />
</template>
