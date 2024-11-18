<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    text: String,
    src: String,
});
</script>

<template>
    <Link
        :href="src"
        class="text-sm text-secondary hover:text-primary"
    >
        {{ text }}
    </Link>
</template>
