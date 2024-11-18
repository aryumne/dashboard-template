<script setup>
defineProps({
    columnName: {
        type: String,
        required: false,
    },
    withSorter: {
        type: Boolean,
        default: false,
    },
    sorterName: {
        type: String,
        required: false,
    },
    sortKey: {
        type: String,
        required: false,
    },
    sortOrder: {
        type: String,
        required: false,
    },
    colSpan: {
        type: Number,
        default: 1,
    },
    rowSpan: {
        type: Number,
        default: 1,
    },
    textAlign: {
        type: String,
        default: "text-left",
    },
    isLast: {
        type: Boolean,
        default: false,
    },
    customClass: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <th
        :rowspan="rowSpan"
        :colspan="colSpan"
        class="px-4 py-1 whitespace-nowrap text-sm leading-normal text-contentc bg-neutral-200 dark:bg-neutral-500 tracking-wider"
        :class="[textAlign, !isLast ? 'border-r border-r-neutral-400 dark:border-neutral-400' : '', customClass]"
    >
        <div
            v-if="withSorter"
            class="w-full flex items-center justify-between space-x-2"
        >
            <span>{{ columnName }}</span>
            <div class="flex flex-col items-center text-xs">
                <span
                    class="-mb-1 cursor-pointer"
                    @click="$emit('sort', sorterName, 'asc')"
                    :class="[
                        sortKey == sorterName && sortOrder === 'asc'
                            ? 'text-primary'
                            : 'text-highlight',
                    ]"
                    >▲</span
                >
                <span
                    class="cursor-pointer"
                    @click="$emit('sort', sorterName, 'desc')"
                    :class="[
                        sortKey == sorterName && sortOrder === 'desc'
                            ? 'text-primary'
                            : 'text-highlight',
                    ]"
                    >▼</span
                >
            </div>
        </div>
        <div v-else>
            <slot />
        </div>
    </th>
</template>
