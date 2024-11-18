<script setup>
import { router } from "@inertiajs/vue3";
const props = defineProps({
    routeName: String,
    rowId: [String, Number],
    clickable: {
        type: Boolean,
        default: true
    },
    isValid: {
        type: Boolean,
        default: true,
    }
})

const handleOnDblClick = () => {
    router.get(props.routeName);
};

</script>

<template>
    <tr v-if="props.clickable" class="border-b border-b-neutral-300 dark:border-b-neutral-500 cursor-pointer group/row"
        :key="props.rowId" @dblclick="handleOnDblClick"
        :class="[props.isValid ? 'even:bg-neutral-100 dark:even:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600' : 'bg-red-200 dark:bg-red-400 hover:bg-red-300 hover:dark:bg-red-500']">
        <slot />
    </tr>
    <template v-else>
        <tr class="border-b border-b-neutral-300 dark:border-b-neutral-500 cursor-auto group/row" :key="props.rowId"
            :class="[props.isValid ? 'even:bg-neutral-100 dark:even:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600' : 'bg-red-200 dark:bg-red-400 hover:bg-red-300 hover:dark:bg-red-500']">
            <slot />
        </tr>
    </template>
</template>