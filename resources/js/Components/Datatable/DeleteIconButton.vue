<script setup>
import { Link } from "@inertiajs/vue3";
import { vTooltip } from 'floating-vue'
defineProps({
    isLink: {
        type: Boolean,
        default: true
    },
    routeName: {
        type: String,
        default: ""
    }
});

defineEmits(['event'])
</script>

<template>
    <Link v-if="isLink"
        :href="routeName"
        v-tooltip="`delete`"
        class="text-red-500 border-2 p-1 border-red-500 rounded transition duration-300 hover:bg-red-500 hover:text-white focus:outline-none"
    >
        <font-awesome-icon icon="fa-solid fa-trash" />
    </Link>
    <button v-else
        @click="$emit('event')"
        v-tooltip="`delete`"
        class="text-red-500 border-2 p-1 border-red-500 rounded transition duration-300 hover:bg-red-500 hover:text-white focus:outline-none"
    >
        <font-awesome-icon icon="fa-solid fa-trash" class="text-lg" />
    </button>
</template>
