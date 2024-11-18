<script setup>
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import SecondaryButton from "@/Components/Elements/SecondaryButton.vue";
import FileInput from "@/Components/Elements/FileInput.vue";
import Modal from "./Modal.vue";
import { onUnmounted } from "vue";

const props = defineProps({
    title: String,
    subtitle: [String, null],
    routeName: String,
    isAddOpen: {
        type: Boolean,
        default: false,
    },
    accept: {
        type: String,
        default: ".xlsx,.xls",
    },
});

const emits = defineEmits(["closeAddModal"]);

const dataForm = useForm({
    file: null,
});

const handleSubmit = () => {
    dataForm.post(route(props.routeName), {
        onSuccess: () => {
            handleCloseModal(true);
        },
    });
};

function handleCloseModal() {
    if(!dataForm.processing) {
        emits("closeAddModal");
        dataForm.reset();
    }
}

onUnmounted(() => {
    dataForm.reset();
});

</script>
<template>
    <Modal :show="isAddOpen" @close="handleCloseModal">
        <div class="p-6">
            <h4 class="text-lg font-bold capitalize text-highlight">
                {{ title }}
            </h4>
            <span v-if="subtitle" class="text-xs text-secondary">{{ subtitle }}</span>
            <form @submit.prevent="handleSubmit">
                <div class="my-8">
                    <FileInput
                            id="file"
                            class="mt-1 block w-full"
                            v-model="dataForm.file"
                            :accept="accept"
                        />
                </div>
                <div class="mt-6 flex justify-end space-x-2 items-center">
                    <SecondaryButton @click="handleCloseModal(false)" :disabled="dataForm.processing">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton button-type="submit" :disabled="dataForm.processing" :is-loading="dataForm.processing">
                        Save
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
