<script setup>
import { Link } from "@inertiajs/vue3";
const currentYear = new Date().getFullYear();

defineProps({
    appInfo: Object
})
</script>
<template>
    <footer class="text-center text-sm text-contentc">
        &copy; {{ currentYear }} copyright
        <span>
            <Link
                :href="route('dashboard')"
                class="text-primary hover:underline"
            >
                {{ appInfo.brand_name }}</Link
            > </span
        >, All rights reserved.
    </footer>
</template>
