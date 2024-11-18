<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import ContentBoxShadow from "@/Components/Templates/ContentBoxShadow.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import RoleForm from "./Partials/RoleForm.vue";
import { ref } from "vue";

defineProps({
    rows: Object,
    permissions: Array,
});

// For edit mode
const dataForm = ref(null);
const modalTitle = ref("");
const modalRouteName = ref("");
const isEditMode = ref(false);

const isModalOpen = ref(false);

const openCreateModal = () => {
    modalTitle.value = "New Role";
    modalRouteName.value = "role.store";
    isModalOpen.value = true;
};
const openEditModal = (ctg) => {
    isEditMode.value = true;
    modalTitle.value = "Edit Role";
    modalRouteName.value = "role.update";
    dataForm.value = ctg;
    isModalOpen.value = true;
};
const closeModal = () => {
    dataForm.value = null;
    modalTitle.value = "";
    modalRouteName.value = "";
    isEditMode.value = false;
    isModalOpen.value = false;
};
const editable = (roleName) => {
    return ["admin", "editor", "contributor"].includes(roleName);
};
</script>
<template>
    <MainLayout title="Web Identity">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <ContentBoxShadow title="Manage Roles">
                    <div class="mt-6 mb-4">
                        <PrimaryButton @click="openCreateModal">
                            New Role
                        </PrimaryButton>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full">
                            <div class="overflow-hidden">
                                <table class="min-w-full text-center">
                                    <thead class="border-b">
                                        <tr>
                                            <th
                                                scope="col"
                                                class="text-sm font-bold text-highlight px-6 py-3 whitespace-nowrap"
                                            >
                                                role name
                                            </th>
                                            <th
                                                scope="col"
                                                class="text-sm font-bold text-highlight px-6 py-3 whitespace-nowrap"
                                            >
                                                permissions
                                            </th>
                                            <th
                                                scope="col"
                                                class="text-sm font-bold text-highlight px-6 py-3 whitespace-nowrap"
                                            >
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="row in rows?.data"
                                            :key="row.uuid"
                                            class="border-b border-secondary/50 hover:bg-secondary/10"
                                        >
                                            <td
                                                class="text-sm text-contentc font-medium p-3 whitespace-nowrap"
                                            >
                                                {{ row.display_name }}
                                            </td>
                                            <td
                                                class="text-sm text-contentc text-left font-medium p-3 whitespace-normal"
                                            >
                                                {{ row.permissions.join(", ") }}
                                            </td>
                                            <td
                                                class="text-sm text-contentc font-medium p-3 whitespace-nowrap"
                                            >
                                                <button
                                                    v-if="
                                                        !editable(
                                                            row.display_name
                                                        )
                                                    "
                                                    @click="openEditModal(row)"
                                                    class="px-2 py-1 border text-white bg-yellow-500 rounded transition duration-300 hover:bg-yellow-400 hover:text-white hover:border hover:border-white focus:outline-none dark:border-transparent"
                                                >
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <RoleForm
                        :is-modal-open="isModalOpen"
                        @close-modal="closeModal"
                        :title="modalTitle"
                        :route-name="modalRouteName"
                        :is-edit-mode="isEditMode"
                        :data="dataForm"
                        :permissions="permissions"
                    />
                </ContentBoxShadow>
        </div>
    </MainLayout>
</template>
