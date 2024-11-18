<script setup>
import { computed, ref, watch } from "vue";

const props = defineProps({
    modelValue: {
        type: [Object, null],
    },
    buttonText: {
        type: String,
        default: "Browse file",
    },
    accept: {
        type: String,
        required: true,
    }
});
const emits = defineEmits(["update:modelValue"]);

const file = ref({ url: null });
const uploadText = ref("");
const fileInput = ref(null);

const triggerFileInput = () => {
    fileInput.value.click();
};

const handleFileChange = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile) {
        const reader = new FileReader();
        reader.readAsDataURL(selectedFile);
        reader.onload = () => {
            file.value = { file: selectedFile, url: reader.result };
            uploadText.value = selectedFile.name;
            emits("update:modelValue", selectedFile);
        };
    }
};

const removeUpload = () => {
    file.value = { url: null };
    uploadText.value = "";
    fileInput.value = null;
    emits("update:modelValue", null);
};

watch(
    () => props.modelValue,
    (newVal) => {
        if (newVal === null) removeUpload();
    }
);

const trimmedText = computed(() => {
      return uploadText.value.length > 50
        ? uploadText.value.slice(0, 50) + '...'
        : uploadText.value;
    })
</script>

<template>
    <div class="w-full flex flex-col justify-center items-center">
        <div class="flex w-full justify-center">
            <div
                id="upload-button"
                class="flex-none inline-flex items-center px-4 py-2 cursor-pointer rounded-l font-semibold text-sm tracking-wider bg-secondary/70 text-text border border-secondary hover:bg-secondary/50 active:bg-secondary/30 active:text-highlight focus:outline-none focus:text-highlight focus:ring-2 focus:ring-highlight focus:ring-offset-0 transition ease-in-out duration-150"
                @click="triggerFileInput"
            >
                {{ props.buttonText }}
            </div>
            <div
                class="grow border border-gray-300 rounded-r-md flex items-center justify-between bg-white"
            >
                <span id="upload-text" class="p-2">{{ trimmedText }}</span>
                <button
                    id="upload-delete"
                    @click.prevent="removeUpload"
                    :class="{ hidden: !file.url }"
                    class="px-4 text-red-500"
                >
                    <font-awesome-icon icon="fa-solid fa-xmark" />
                </button>
            </div>
        </div>
        <input
            type="file"
            id="upload-input"
            class="hidden"
            :accept="accept"
            @change="handleFileChange"
            ref="fileInput"
        />
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
