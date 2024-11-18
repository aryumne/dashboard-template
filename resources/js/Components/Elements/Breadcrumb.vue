<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    data: Array
})
</script>

<template>
    <nav class="mb-4" aria-label="breadcrumb">
        <ol class="flex space-x-2">
            <template  v-for="(link, index) in data" :key="index">
                <li class="text-sm text-secondary hover:text-primary" v-if="link.url !== '#'">
                    <Link :href="link.url" class="breadcrumb-link">{{ link.name }}</Link>
                </li>
                <li v-else class="text-sm text-highlight font-semibold" aria-current="page">{{ link.name }}</li>
            </template>
        </ol>
    </nav>
</template>

<style scoped>
.breadcrumb-link::after {
    content: '/' !important;
    margin-left: 0.5rem;
    color: inherit;
}

.breadcrumb-link:last-of-type::after {
    content: '';
}
</style>