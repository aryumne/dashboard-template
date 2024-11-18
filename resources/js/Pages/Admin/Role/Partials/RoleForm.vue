<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/Elements/InputLabel.vue";
import TextInput from "@/Components/Elements/TextInput.vue";
import InputError from "@/Components/Elements/InputError.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import SecondaryButton from "@/Components/Elements/SecondaryButton.vue";
import Modal from "@/Components/Templates/Modal.vue";
import ToggleSwitch from "@/Components/Elements/ToggleSwitch.vue";
import { ref, watch } from "vue";

const props = defineProps({
    isModalOpen: {
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
    data: [Object, null],
    isEditMode: {
        type: Boolean,
        default: false,
    },
    permissions: Array,
});
const emits = defineEmits(["closeModal"]);
const idData = ref("");

const dataForm = useForm({
    name: "",
    permissions: [],
});

const onSuccessHandle = () => {
    dataForm.reset();
    emits("closeModal");
};

const handleSubmit = () => {
    props.isEditMode === true
        ? dataForm.patch(route(props.routeName, idData.value), {
              onSuccess: onSuccessHandle,
          })
        : dataForm.post(route(props.routeName), {
              onSuccess: onSuccessHandle,
          });
};
watch(
    () => props.data,
    (dt) => {
        if (props.isEditMode && dt !== null) {
            idData.value = dt.uuid;
            dataForm.name = dt.display_name;
            dataForm.permissions = dt.permissions;
        }
    }
);
</script>
<template>
    <!-- Create Tag Modal -->
    <Modal :show="isModalOpen" @close="emits('closeModal')">
        <div class="p-6">
            <h4 class="text-lg font-bold capitalize text-contentc mb-8">
                {{ props.title }}
            </h4>
            <form @submit.prevent="handleSubmit">
                <div>
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="dataForm.name"
                        required
                    />
                    <InputError class="mt-2" :message="dataForm.errors.name" />
                </div>
                <div class="mt-4">
                    <InputLabel for="permissions" value="Permissions" />
                    <div class="mt-2 grid grid-cols-2 md:grid-cols-3">
                        <div
                            v-for="(option, index) in props.permissions"
                            :key="index"
                            class="flex items-center mb-2 pl-2"
                        >
                            <input
                                type="checkbox"
                                :id="'checkbox-' + index"
                                :value="option"
                                v-model="dataForm.permissions"
                                class="form-checkbox h-4 w-4 text-primary rounded-md border border-gray-300 transition duration-150 ease-in-out"
                            />
                            <label
                                :for="'checkbox-' + index"
                                class="ml-3 block text-sm font-semibold text-contentc"
                            >
                                {{ option }}
                            </label>
                        </div>
                    </div>
                    <InputError
                        class="mt-2"
                        :message="dataForm.errors.permissions"
                    />
                </div>

                <div class="mt-6 flex justify-end space-x-2 items-center">
                    <SecondaryButton @click="emits('closeModal')" :disabled="dataForm.processing">
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
