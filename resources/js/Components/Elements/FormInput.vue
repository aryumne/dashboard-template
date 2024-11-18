<script setup>
const props = defineProps({
  id: String,
  type: {
    type: String,
    default: 'text'
  },
  modelValue: [String, Number],
  isRequired: {
    type: Boolean,
    default: false
  },
  isDisabled: {
    type: Boolean,
    default: false
  },
  customSize: {
    type: String,
    default: 'p-2 text-sm'
  },
  isDecimal: {
    type: Boolean,
    default: false,
  },
  placeholder: {
    type: String,
    default: "type here"
  }
});
const modelValue = defineModel({
  prop: 'modelValue',
  event: 'update:modelValue',
  default: ''
});
</script>

<template>
    <input
       v-if="isDecimal"
        :id="id"
        type="number"
        class="text-contentc bg-transparent border border-gray-400 focus:border-primary focus:ring-primary rounded-md shadow-sm disabled:bg-secondary/30 placeholder:italic placeholder:text-secondary/90"
        :class="[isDisabled === true ? 'cursor-not-allowed': 'cursor-text', customSize]"
        v-model="modelValue"
        ref="input"
        :required="isRequired"
        :disabled="isDisabled"
        :placeholder="placeholder"
        step="0.01" min="0"
    />
    <input
    v-else
        :id="id"
        :type="type"
        class="text-contentc bg-transparent border border-gray-400 focus:border-primary focus:ring-primary rounded-md shadow-sm disabled:bg-secondary/30 placeholder:italic placeholder:text-secondary/90"
        :class="[isDisabled === true ? 'cursor-not-allowed': 'cursor-text', customSize]"
        v-model="modelValue"
        :placeholder="placeholder"
        ref="input"
        :required="isRequired"
        :disabled="isDisabled"
    />
</template>