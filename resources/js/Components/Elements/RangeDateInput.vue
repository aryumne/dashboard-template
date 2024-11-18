<script setup>
import { ref, watch, onMounted } from "vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const props = defineProps({
    modelValue: String,
});
const emits = defineEmits(["update:modelValue"]);

const date = ref();
const format = (date) => {
    const startDay = date[0].getDate().toString().padStart(2, "0");
    const startMonth = (date[0].getMonth() + 1).toString().padStart(2, "0");
    const startYear = date[0].getFullYear();
    let startDate = `${startYear}-${startMonth}-${startDay} 00:00:00`;
    let endDate = `${startYear}-${startMonth}-${startDay} 23:59:59`;
    if (date[1]) {
        const endDay = date[1].getDate().toString().padStart(2, "0");
        const endMonth = (date[1].getMonth() + 1).toString().padStart(2, "0");
        const endYear = date[1].getFullYear();
        endDate = `${endYear}-${endMonth}-${endDay} 23:59:59`;
    }
    const newDate = `${startDate},${endDate}`;
    emits("update:modelValue", newDate);
    return newDate;
};
watch(
    () => date.value,
    (newVal) => {
        if (newVal === null) {
            emits("update:modelValue", null);
        }
    }
);
onMounted(() => {
    if (props.modelValue) {
        let rangeDate = props.modelValue.split(",");
        const formatedRange = rangeDate.map((el) => new Date(el), []);
        date.value = formatedRange;
    } else {
        date.value = null;
    }
});
</script>

<template>
    <VueDatePicker
        v-model="date"
        class="datetime-input"
        :format="format"
        range
        :partial-range="false"
        :enable-time-picker="false"
    />
</template>
<style>
.datetime-input input {
    @apply p-3 pl-10 border border-gray-400 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm;
}
</style>
