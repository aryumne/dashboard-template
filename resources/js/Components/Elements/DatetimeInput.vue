<script setup>
import { ref } from "vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { onMounted } from "vue";

const props = defineProps({
    modelValue: [String, new Date()],
    withTime: {
        type: Boolean,
        default: true,
    },
});
const emits = defineEmits(["update:modelValue"]);

const date = ref("");
const format = (date) => {
    let dateString = "";
    const day = date.getDate().toString().padStart(2, "0");
    const month = (date.getMonth() + 1).toString().padStart(2, "0");
    const year = date.getFullYear();
    dateString = `${year}-${month}-${day}`;
    if (props.withTime === true) {
        const hours = date.getHours().toString().padStart(2, "0");
        const minutes = date.getMinutes().toString().padStart(2, "0");
        dateString = `${dateString} ${hours}:${minutes}:00`;
    }
    emits("update:modelValue", dateString);
    return dateString;
};

onMounted(() => {
    date.value = props.modelValue || format(new Date());
    emits("update:modelValue", date.value);
});
</script>

<template>
    <VueDatePicker
        v-model="date"
        class="datetime-input"
        :format="format"
        :enable-time-picker="props.withTime"
    />
</template>
<style>
.datetime-input input {
    @apply p-3 pl-10 border border-gray-400 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm;
}
</style>
