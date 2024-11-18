<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/Elements/InputLabel.vue";
import TextInput from "@/Components/Elements/TextInput.vue";
import InputError from "@/Components/Elements/InputError.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import SecondaryButton from "@/Components/Elements/SecondaryButton.vue";
import ToggleSwitch from "@/Components/Elements/ToggleSwitch.vue";
import Modal from "@/Components/Templates/Modal.vue";
import { ref, watch } from "vue";

const props = defineProps({
    isEditOpen: {
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
        required: true,
    },
    hasIsActive: {
        type: Boolean,
        default: false
    }
});

const dataForm = useForm({
    name: "",
    is_active: "",
});
const idData = ref("");

const emits = defineEmits(["closeEditModal"]);

const handleSubmit = () => {
    dataForm.patch(route(props.routeName, idData.value), {
        onSuccess: () => emits("closeEditModal"),
    });
};

watch(
    () => props.data,
    (dt) => {
        idData.value = dt.id;
        dataForm.name = dt.name;
        dataForm.is_active = dt?.is_active;
    }
);
</script>
<template>
    <Modal :show="isEditOpen" @close="emits('closeEditModal')">
        <div class="p-6">
            <h4 class="text-lg font-bold capitalize text-gray-700 dark:text-gray-200 mb-8">
                {{ props.title }}
            </h4>
            <form @submit.prevent="handleSubmit">
                <div class="mt-4">
                    <InputLabel for="name" value="Display Name" :is-required="true" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="dataForm.name" required />

                    <InputError class="mt-2" :message="dataForm.errors.name" />
                </div>
                <div class="mt-4" v-if="props.hasIsActive">
                    <ToggleSwitch v-model="dataForm.is_active" label="Active" />
                </div>
                <div class="mt-6 flex justify-end space-x-2 items-center">
                    <SecondaryButton @click="emits('closeEditModal')" :disabled="dataForm.processing">
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
