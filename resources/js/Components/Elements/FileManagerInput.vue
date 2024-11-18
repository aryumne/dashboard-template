<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    modelValue: {
        type: [String, ""],
    },
    isLogoMode: {
        type: Boolean,
        default: false,
    },
    readOnly: {
        type: Boolean,
        default: true,
    },
    buttonText: {
        type: String,
        default: "Choose Image",
    },
});
const emits = defineEmits(["update:modelValue"]);
const stringUrl = ref(props.modelValue);

const setImageUrl = (url) => {
    stringUrl.value = url[0].url;
};
const openFileManager = () => {
    window.open(
        "/laravel-filemanager?type=Images",
        "FileManager",
        "width=900,height=600"
    );
    window.SetUrl = setImageUrl;
};
const removeUpload = () => {
    stringUrl.value = "";
};

watch(
    () => stringUrl.value,
    (newVal) => {
        emits("update:modelValue", newVal);
    }
);
</script>

<template>
    <div class="flex flex-col justify-center items-center">
        <div
            v-if="props.modelValue"
            class="w-full mb-3 rounded-lg bg-gray-100 bg-center flex justify-center shadow border border-bgc-1/50"
        >
            <img
                :src="props.modelValue"
                class="max-h-44 h-full object-center rounded"
                :class="
                    props.isLogoMode ? 'rounded-full' : 'w-auto object-cover'
                "
            />
        </div>
        <div class="flex justify-center w-full">
            <div
                id="upload-button"
                class="flex-none inline-flex items-center px-4 py-2 bg-gray-300 border border-gray-300 rounded-l font-semibold cursor-pointer text-sm text-gray-800 tracking-wide hover:bg-gray-200 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                @click.prevent="openFileManager"
            >
                {{ props.buttonText }}
            </div>
            <div
                class="grow border border-gray-400 rounded-r-md inline-flex items-center justify-between bg-white"
            >
                <input
                    id="upload-text"
                    class="p-2 text-sm w-full border border-transparent focus:border-primary focus:ring-primary"
                    v-model="stringUrl"
                    :readonly="props.readOnly"
                />
                <button
                    id="upload-delete"
                    @click.prevent="removeUpload"
                    :class="{ hidden: props.modelValue === '' }"
                    class="px-4 text-red-500"
                >
                    <font-awesome-icon icon="fa-solid fa-xmark" />
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter,
.fade-leave-to /* .fade-leave-active in <2.1.8 */ {
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
