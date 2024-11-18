<script setup>
defineProps({
    label: {
        type: String,
        required: true,
    },
    id: {
        type: String,
        default: "toggle",
    },
    customSize: {
        type: String,
        default: 'standart'
    }
});
const model = defineModel();
</script>
<template>
    <div v-if="customSize === 'standart'">
        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
            <input type="checkbox" name="toggle" v-model="model" :id="id"
                class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-2 appearance-none cursor-pointer" />
            <label :for="id"
                class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
        </div>
        <label :for="id" class="text-sm uppercase font-semibold text-contentc">
            {{ label }}
        </label>
    </div>
    <div v-if="customSize === 'small'" class="flex align-center">
        <div class="relative inline-block w-8 mr-2 align-middle select-none transition duration-200 ease-in">
            <input type="checkbox" name="toggle" v-model="model" :id="id"
                class="toggle-checkbox absolute block w-4 h-4 rounded-full bg-white border-2 appearance-none cursor-pointer" />
            <label :for="id"
                class="toggle-label block overflow-hidden h-4 rounded-full bg-gray-300 cursor-pointer"></label>
        </div>
        <label :for="id" class="text-xs uppercase font-semibold text-contentc">
            {{ label }}
        </label>
    </div>
</template>
<style scoped>
/* CHECKBOX TOGGLE SWITCH */
/* @apply rules for documentation, these do not work as inline style */
.toggle-checkbox:checked {
    @apply: right-0 border-green-400;
    right: 0;
    border-color: #68d391;
}

.toggle-checkbox:checked+.toggle-label {
    @apply: bg-green-400;
    background-color: #68d391;
}
</style>
