<script setup>
defineProps({
    label: String
});
</script>

<template>
    <tr>
        <th
            class="p-1 w-[1px] text-left capitalize font-medium text-xs text-contentc whitespace-nowrap align-top"
        >
            {{ label }}
        </th>
        <td class="p-1 text-sm w-[1px] whitespace-nowrap align-top">:</td>
        <td class="p-1 text-sm text-contentc font-semibold tracking-wide align-top">
          <slot/>
        </td>
    </tr>
</template>
