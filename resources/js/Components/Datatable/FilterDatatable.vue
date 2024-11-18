<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
const isOpen = ref(false);

const toggleFilter = () => {
    isOpen.value = !isOpen.value;
}
</script>

<template>
    <div class="flex justify-between items-center mb-4">
        <PrimaryButton @click="toggleFilter"> Filter </PrimaryButton>
    </div>

    <div class="bg-boxc w-full rounded-lg shadow">
        <Transition name="collapse">
            <div v-show="isOpen" class="p-4 pt-8 sm:p-6 xl:p-8 mb-4">
                <slot />
            </div>
        </Transition>
    </div>
</template>
