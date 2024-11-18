<script setup>
defineProps({
    label: String,
    value: [String, Number, null],
});
</script>

<template>
    <tr>
        <td
            class="p-1 w-[1px] text-left capitalize font-medium text-xs text-contentc whitespace-nowrap align-top"
        >
            {{ label }}
        </td>
        <td class="p-1 text-sm w-[1px] whitespace-nowrap align-top">:</td>
        <td class="p-1 text-sm text-highlight font-semibold align-top">
            {{ value }}
        </td>
    </tr>
</template>
