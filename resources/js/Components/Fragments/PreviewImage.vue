<script setup>
import { ref } from "vue";
defineProps({
    imgSrc: {
        type: String,
        required: true,
    },
    imgAlt: {
        type: String,
        required: true,
    },
    customClass: {
        type: String,
        required: false,
    },
});

const isOpen = ref(false);
const openModal = () => {
    isOpen.value = true;
};
const closeModal = () => {
    isOpen.value = false;
};
</script>

<template>
    <div :class="customClass">
        <img
            :src="imgSrc"
            :alt="imgAlt"
            @click="openModal"
            class="w-full h-full object-cover rounded-md hover:opacity-50 hover:cursor-pointer"
        />
    </div>
    <Teleport to="body">
        <Transition leave-active-class="duration-200">
            <div
                v-show="isOpen"
                class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 flex justify-center items-center"
                scroll-region
            >
                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-show="isOpen"
                        class="fixed inset-0 transform transition-all"
                        @click="closeModal"
                    >
                        <div
                            class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"
                        />
                    </div>
                </Transition>

                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        v-show="isOpen"
                        class="bg-transparent overflow-hidden transform transition-all p-8 w-full lg:max-w-7xl"
                    >
                        <button
                            @click="closeModal"
                            aria-expanded="true"
                            aria-controls="sidebar"
                            class="absolute text-xl top-0 right-0 text-gray-600 hover:text-gray-50 dark:text-gray-300 cursor-pointer p-2 px-3 rounded"
                        >
                            <font-awesome-icon icon="fa-solid fa-xmark" />
                        </button>
                        <img
                            :src="imgSrc"
                            :alt="imgAlt"
                            class="h-full w-full object-cover"
                        />
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
