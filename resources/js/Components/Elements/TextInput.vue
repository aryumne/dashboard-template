<script setup>
import { onMounted, ref } from "vue";

defineProps({
    type: {
        type: String,
        default: "text",
    },
    isSmall: {
        type: Boolean,
        default: false,
    },
});
const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        :type="type"
        :class="isSmall ? 'p-1 text-sm' : 'p-3'"
        class="border text-contentc bg-transparent border-gray-400 focus:border-primary focus:ring-primary rounded-md shadow-sm"
        v-model="model"
        ref="input"
    />
</template>
