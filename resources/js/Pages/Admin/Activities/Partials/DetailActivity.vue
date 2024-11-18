<script setup>
import Modal from "@/Components/Templates/Modal.vue";
import SecondaryButton from "@/Components/Elements/SecondaryButton.vue";
defineProps({
    isPreviewOpen: {
        type: Boolean,
        default: false,
    },
    data: Object,
    title: {
        type: String,
        required: true,
    },
});
const emits = defineEmits(["closePreviewModal"]);
</script>
<template>
    <Modal
        :show="isPreviewOpen"
        @close="emits('closePreviewModal')"
        max-width="extraLarge"
    >
        <div class="p-6">
            <h1 class="text-xl font-semibold text-primary mb-4">
                Detail Activity
            </h1>
            <div class="block w-full overflow-auto">
                <table
                    class="items-center bg-transparent w-full border-collapse"
                >
                    <tbody>
                        <tr class="border-b border-secondary/30">
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-left text-contentc/80 bg-secondary/10"
                            >
                                Created at
                            </th>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-contentc"
                            >
                                {{ data.created_at }}
                            </td>
                        </tr>
                        <tr class="border-b border-secondary/30">
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-left text-contentc/80 bg-secondary/10"
                            >
                                Log name
                            </th>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-contentc"
                            >
                                {{ data.log_name }}
                            </td>
                        </tr>
                        <tr class="border-b border-secondary/30">
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-left text-contentc/80 bg-secondary/10"
                            >
                                Event
                            </th>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-contentc"
                            >
                                {{ data.event }}
                            </td>
                        </tr>
                        <tr class="border-b border-secondary/30">
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-left text-contentc/80 bg-secondary/10"
                            >
                                Description
                            </th>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-contentc"
                            >
                                {{ data.description }}
                            </td>
                        </tr>
                        <tr class="border-b border-secondary/30">
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-left text-contentc/80 bg-secondary/10"
                            >
                                Actor name
                            </th>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-contentc"
                            >
                                {{ data.actor_name }}
                            </td>
                        </tr>
                        <tr class="border-b border-secondary/30">
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-left text-contentc/80 bg-secondary/10"
                            >
                                Actor role
                            </th>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-contentc"
                            >
                                {{ data.actor_role }}
                            </td>
                        </tr>
                        <tr class="border-b border-secondary/30">
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-left text-contentc/80 bg-secondary/10"
                            >
                                Changed Attributes
                            </th>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-normal p-2 text-contentc"
                            >
                                <div
                                    class="flex flex-col w-full"
                                    v-if="'attributes' in data.properties"
                                >
                                    <div
                                        class="w-full border-secondary/10 border-b py-2"
                                        v-for="(value, key) in data.properties
                                            .attributes"
                                        :key="key"
                                    >
                                        <strong>{{ key }}:</strong>
                                        <p class="ml-3">{{ value }}</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-secondary/30">
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-left text-contentc/80 bg-secondary/10"
                            >
                                Old Attributes
                            </th>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-normal p-2 text-contentc"
                            >
                                <div
                                    class="flex flex-col w-full"
                                    v-if="'old' in data.properties"
                                >
                                    <div
                                        class="w-full border-secondary/10 border-b py-2"
                                        v-for="(value, key) in data.properties
                                            .old"
                                        :key="key"
                                    >
                                        <strong>{{ key }}:</strong>
                                        <p class="ml-3">{{ value }}</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="emits('closePreviewModal')">
                        Close
                    </SecondaryButton>
                </div>
            </div>
        </div>
    </Modal>
</template>
