<script setup>
import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        required: true,
    },
    value: {
        default: null,
    },
    name: {
        type: String,
        default:"checkbox"
    },
    isDisabled: {
        type: Boolean,
        default:false
    }
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit("update:checked", val);
    },
});
</script>

<template>
    <input
        :id="name"
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        :disabled="isDisabled"
        :class="[isDisabled === true ? 'cursor-not-allowed': 'cursor-pointer']"
        class="rounded  border-gray-300 text-lg text-primary shadow-sm focus:ring-indigo-500 disabled:opacity-50"
    />
</template>
