<script setup>
import { onMounted } from "vue";
import { computed, ref, watch } from "vue";

const props = defineProps({
    message: String,
    type: {
        type: String,
        default: "info",
    },
});

const open = ref(!!props.message);
const duration = ref(10000);
let timer;

const closeToast = () => {
    open.value = false;
    clearTimeout(timer);
};

const toastColor = computed(() => {
    return {
        success: "bg-green-500 hover:bg-green-600",
        failed: "bg-red-500 hover:bg-red-600",
        info: "bg-amber-500 hover:bg-amber-600",
    }[props.type];
});

const toastIcon = computed(() => {
    return {
        success: "fa-solid fa-check",
        failed: "fa-solid fa-xmark",
        info: "fa-solid fa-circle-exclamation",
    }[props.type];
});

watch(
    () => props.message,
    (_) => {
        open.value = true;
        clearTimeout(timer);
        timer = setTimeout(() => {
            open.value = false;
        }, duration.value);
    },
    { immediate: true }
);

onMounted(() => {
    if (props.message) {
        timer = setTimeout(() => {
            open.value = false;
        }, duration.value);
    }
});
</script>

<template>
    <transition name="fade" mode="out-in">
        <button
            v-if="open"
            @click="closeToast"
            class="fixed right-4 top-4 z-50 rounded-md mt-2 px-4 py-2 text-white transition"
            :class="toastColor"
        >
            <div class="flex items-center space-x-2">
                <span class="text-2xl">
                    <font-awesome-icon :icon="toastIcon" />
                </span>
                <p class="font-bold">{{ props.message }}</p>
            </div>
            <div
                class="loading-bar mt-2 h-1 bg-white"
                :style="{ animationDuration: `${duration / 1000}s` }"
            ></div>
        </button>
    </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0;
}
.loading-bar {
    width: 100%;
    animation-name: shrink;
    animation-timing-function: linear;
    animation-fill-mode: forwards;
}

@keyframes shrink {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}
</style>
