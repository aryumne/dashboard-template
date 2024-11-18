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
        v-tooltip="`detail`"
        class="text-blue-500 border-2 p-1 border-blue-500 rounded transition duration-300 hover:bg-blue-500 hover:text-white focus:outline-none"
    >
        <font-awesome-icon icon="fa-solid fa-eye" />
    </Link>
    <button v-else
        @click="$emit('event')"
        v-tooltip="`detail`"
        class="text-blue-500 border-2 p-1 border-blue-500 rounded transition duration-300 hover:bg-blue-500 hover:text-white focus:outline-none"
    >
        <font-awesome-icon icon="fa-solid fa-eye" />
    </button>
</template>
