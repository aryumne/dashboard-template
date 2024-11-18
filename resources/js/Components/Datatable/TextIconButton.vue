<script setup>
import { Link } from "@inertiajs/vue3";
import { vTooltip } from "floating-vue";
defineProps({
  isLink: {
    type: Boolean,
    default: true,
  },
  routeName: {
    type: String,
    default: "",
  },
  text: {
    type: String,
    required: true,
  },
  iconName: {
    type: String,
    default: "fa-solid fa-plus",
  },
  hoverText: String,
  isOutline: {
    type: Boolean,
    default: false,
  },
  customSize: {
    type: String,
    default: "p-1",
  },
  disabled: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["event"]);
</script>

<template>
  <Link v-if="isLink" :href="routeName">
    <button
      class="inline-flex h-full tracking-wide font-semibold border-2 rounded transition duration-300 focus:outline-none"
      :class="[
        !isOutline
          ? 'bg-primary text-white border-transparent hover:bg-transparent hover:text-primary hover:border-primary'
          : 'text-primary border-primary hover:bg-primary hover:text-white', disabled ? 'opacity-50': ''
      ]"
      :disabled="disabled"
    >
      <div class="flex space-x-1 items-center text-xs" :class="[customSize]">
        <font-awesome-icon :icon="iconName" />
        <span>{{ text }}</span>
      </div>
    </button>
  </Link>
  <button
    v-else
    v-tooltip="hoverText"
    @click="$emit('event')"
    class="inline-flex h-full tracking-wide font-semibold border-2 rounded transition duration-300 focus:outline-none"
    :class="[
      !isOutline
        ? 'bg-primary text-white border-transparent hover:bg-transparent hover:text-primary hover:border-primary'
        : 'text-primary border-primary hover:bg-primary hover:text-white',
    disabled ? 'opacity-50': '']"
    :disabled="disabled"
  >
    <div class="flex space-x-1 items-center text-xs" :class="[customSize]">
      <font-awesome-icon :icon="iconName" />
      <span>{{ text }}</span>
    </div>
  </button>
</template>
