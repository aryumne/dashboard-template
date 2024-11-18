<script setup>
import axios from "axios";
import { ref, watch } from "vue";

const props = defineProps({
    multiple: {
        type: Boolean,
        default: true,
    },
    modelValue: {
        type: Array,
        default: () => [],
    },
    notes: [String, null]
});

const emit = defineEmits(["update:modelValue"]);

const uploadStatus = ref([]);
const isUploading = ref(false);
const isDragging = ref(false);

const handleUpload = async (event) => {
    let selectedFiles = event.target.files || event.dataTransfer.files;
    if (selectedFiles.length === 0) return;

    if (selectedFiles.length > 1 && props.multiple === false)
        selectedFiles = [selectedFiles[0]];

    // Validate file extension
    for (let i = 0; i < selectedFiles.length; i++) {
        const file = selectedFiles[i];
        const fileExtension = file.name.split(".").pop().toLowerCase();

        if (!["xlsx"].includes(fileExtension)) {
            alert(
                `File ${file.name} is not allowed. Please upload files with the following extensions: .xlsx`
            );
            return;
        }
    }

    isUploading.value = true;
    const tempUploadStatus = [];

    for (let i = 0; i < selectedFiles.length; i++) {
        const formData = new FormData();
        formData.append("file", selectedFiles[i]);
        const fileStatus = {
            name: selectedFiles[i].name,
            progress: 0,
            success: null,
            error: null,
            path: null,
        };
        try {
            const response = await axios.post(
                route("api.product.upload.single"),
                formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    onUploadProgress: (progressEvent) => {
                        fileStatus.progress = Math.round(
                            (progressEvent.loaded * 100) / progressEvent.total
                        );
                    },
                }
            );

            fileStatus.success = true;
            fileStatus.path = response.data.path;
            tempUploadStatus.push(fileStatus);
        } catch (error) {
            fileStatus.success = false;
            fileStatus.error = error.response
                ? error.response.data.message
                : "Upload failed";
            tempUploadStatus.push(fileStatus);
        }
    }
    isUploading.value = false;
    uploadStatus.value = [...uploadStatus.value, ...tempUploadStatus];

    syncToModel(uploadStatus.value)
};

const handleDragOver = () => {
    isDragging.value = true;
};

const handleDragLeave = () => {
    isDragging.value = false;
};

const handleDrop = (event) => {
    isDragging.value = false;
    handleUpload(event);
};

const removeFile = (index) => {
    const newUploadStatus = [...uploadStatus.value];
    newUploadStatus.splice(index, 1);
    uploadStatus.value = newUploadStatus;
    syncToModel(uploadStatus.value)
};

function syncToModel(newVal) {
    const uploadedFiles = newVal
            .filter((file) => file.success === true)
            .map((file) => file.path);
    emit("update:modelValue", uploadedFiles);
}

watch(
    () => props.modelValue,
    (newVal) => {
        if(newVal.length === 0) uploadStatus.value = []
    }
);

</script>

<template>
    <div class="flex items-center justify-center">
        <div class="mx-auto w-full">
            <div>
                <div class="flex items-center justify-center w-full mb-2">
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-secondary border-dashed rounded-lg cursor-pointer bg-bgc-1/50 hover:bg-bgc-1"
                        @dragover.prevent="handleDragOver" @dragleave="handleDragLeave" @drop.prevent="handleDrop"
                        :class="{ 'bg-bgc-2': isDragging }">
                        <div class="flex items-center justify-center min-h-screen" v-if="isUploading">
                            <div class="w-8 h-8 border-4 border-blue-200 rounded-full animate-spin"></div>
                            <p class="ml-2">uploading...</p>
                        </div>
                        <template v-else>
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <p class="mb-2 text-sm text-secondary px-2 text-center">
                                    <span class="font-semibold">Click to upload</span>
                                    or drag and drop ( only .xlsx)
                                </p>
                                <p class="text-xs uppercase text-primary px-2 text-center">
                                    {{ props.notes }}
                                </p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" accept=".xlsx" :multiple="multiple"
                                @change.prevent="handleUpload" />
                        </template>
                    </label>
                </div>
                <div v-for="(file, index) in uploadStatus" :key="index"
                    class="rounded-md bg-secondary/20 px-4 py-1 pt-2 my-2 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="truncate pr-3 font-semibold text-contentc">
                            {{ file.name }}
                        </span>
                        <button class="text-contentc" @click.prevent="removeFile(index)">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                                    fill="currentColor" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                                    fill="currentColor" />
                            </svg>
                        </button>
                    </div>
                    <div class="relative mt-1 h-[6px] w-full rounded-lg bg-green-100" v-if="file.progress < 100">
                        <div class="absolute left-0 right-0 h-full rounded-lg bg-green-500"
                            :style="{ widht: file.progress + '%' }">
                        </div>
                    </div>
                    <div v-if="file.success" class="mt-1 text-green-500">
                        File Added.
                    </div>
                    <div v-else-if="file.success === false" class="mt-2 text-red-500">
                        Failed to adding file! {{ file.error }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
