<script setup>
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import SecondaryButton from "@/Components/Elements/SecondaryButton.vue";
import Modal from "@/Components/Templates/Modal.vue";

const props = defineProps({
    isDeleteOpen: {
        type: Boolean,
        default: false,
    },
    data: Object,
    routeName: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        default: "Delete confirmation",
    },
    subtitle: {
        type: String,
        default: "Are you sure to delete this?",
    },
});

const dataForm = useForm({});

const emits = defineEmits(["closeDeleteModal"]);

const handleSubmit = () => {
    dataForm.delete(route(props.routeName, props.data.id), {
        onSuccess: () => emits("closeDeleteModal"),
    });
};

</script>
<template>
    <Modal :show="isDeleteOpen" @close="emits('closeDeleteModal')" max-width="md">
        <div class="p-6">
            <h4 class="text-center text-lg font-bold capitalize text-highlight mb-6">
                {{ props.title }}
            </h4>
            <form @submit.prevent="handleSubmit">
                <div class="mt-4">
                    <p class="text-contentc text-center">
                        {{ props.subtitle }}
                    </p>
                </div>
                <div class="mt-6 flex justify-center space-x-4 items-center">
                    <SecondaryButton @click="emits('closeDeleteModal')" :disabled="dataForm.processing">
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
