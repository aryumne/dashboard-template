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
        v-tooltip="`edit`"
        class="text-amber-500 border-2 p-1 border-amber-500 rounded transition duration-300 hover:bg-amber-500 hover:text-white focus:outline-none"
    >
        <font-awesome-icon icon="fa-solid fa-pen" class="text-md" />
    </Link>
    <button v-else
        @click="$emit('event')"
        v-tooltip="`edit`"
        class="text-amber-500 border-2 p-1 border-amber-500 rounded transition duration-300 hover:bg-amber-500 hover:text-white focus:outline-none" 
    >
        <font-awesome-icon icon="fa-solid fa-pen" />
    </button>
</template>
