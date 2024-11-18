<script setup>
defineProps({
    columnTotal: Number
})
</script>
<template>
  <tr class="border-b border-b-secondary border-r-secondary/35">
    <td
      class="py-4 bg-secondary/20 text-center text-contentc text-sm tracking-wider"
      :colspan="columnTotal"
    >
      No Data Available
    </td>
  </tr>
</template>