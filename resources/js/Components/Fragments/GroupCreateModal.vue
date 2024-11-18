<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/Elements/InputLabel.vue";
import TextInput from "@/Components/Elements/TextInput.vue";
import InputError from "@/Components/Elements/InputError.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import SecondaryButton from "@/Components/Elements/SecondaryButton.vue";
import Modal from "@/Components/Templates/Modal.vue";

const props = defineProps({
    isCreateOpen: {
        type: Boolean,
        default: false,
    },
    routeName: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
});
const emits = defineEmits(["closeCreateModal"]);

const dataForm = useForm({
    name: "",
});

const handleSubmit = () => {
    dataForm.post(route(props.routeName), {
        onSuccess: () => {
            dataForm.reset();
            emits("closeCreateModal");
        },
    });
};
</script>
<template>
    <!-- Create Tag Modal -->
    <Modal :show="isCreateOpen" @close="emits('closeCreateModal')">
        <div class="p-6">
            <h4
                class="text-lg font-bold capitalize text-gray-700 dark:text-gray-200 mb-8"
            >
                {{ props.title }}
            </h4>
            <form @submit.prevent="handleSubmit">
                <div class="mt-4">
                    <InputLabel
                        for="name"
                        value="Display Name"
                        :is-required="true"
                    />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="dataForm.name"
                        required
                    />

                    <InputError
                        class="mt-2"
                        :message="dataForm.errors.name"
                    />
                </div>
                <div class="mt-6 flex justify-end space-x-2 items-center">
                    <SecondaryButton @click="emits('closeCreateModal')" :disabled="dataForm.processing">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton button-type="submit" class="ms-3" :disabled="dataForm.processing" :is-loading="dataForm.processing">
                        Save
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
