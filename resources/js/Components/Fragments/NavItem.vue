<script setup>
import { Link } from "@inertiajs/vue3";
import { triggerRef } from "vue";
defineProps({
    isShow: {
        type: Boolean,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    activeRouteName: {
        type: String,
        required: true,
    },
    menuName: {
        type: String,
        required: true,
    },
    initialName: {
        type: String,
        required: false,
    },
    isSubMenu: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <Link
        v-if="!isSubMenu"
        :href="route(routeName)"
        :class="{ 'bg-primary/30': route().current(activeRouteName) }"
        class="text-sm text-contentc font-normal rounded-lg flex items-center p-2 hover:bg-primary/30 hover:text-primary"
    >
        <slot name="svgIcon" />
        <span v-if="isShow" class="ml-3">{{ menuName }}</span>
    </Link>
    <Link
        v-else
        :href="route(routeName)"
        :class="{ 'text-primary': route().current(activeRouteName) }"
        class="text-sm text-contentc font-normal rounded-lg flex items-center p-2 hover:text-primary"
    >
        <slot name="svgIcon" />
        <span v-if="!isShow" class="-ml-2">{{ initialName }}</span>
        <span v-else class="ml-3">{{ menuName }}</span>
    </Link>
</template>
