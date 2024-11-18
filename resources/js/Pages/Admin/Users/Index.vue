<script setup>
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import Checkbox from "@/Components/Elements/Checkbox.vue";
import HeaderDatatable from "@/Components/Datatable/HeaderDatatable.vue";
import BodyDatatable from "@/Components/Datatable/BodyDatatable.vue";
import RowHead from "@/Components/Datatable/RowHead.vue";
import RowBody from "@/Components/Datatable/RowBody.vue";
import ColumnHead from "@/Components/Datatable/ColumnHead.vue";
import ColumnBody from "@/Components/Datatable/ColumnBody.vue";
import NoDataAvailableRow from "@/Components/Datatable/NoDataAvailableRow.vue";
import FooterDatatable from "@/Components/Datatable/FooterDatatable.vue";
import EditIconButton from "@/Components/Datatable/EditIconButton.vue";
import DeleteIconButton from "@/Components/Datatable/DeleteIconButton.vue";
import ContentBoxShadow from "@/Components/Templates/ContentBoxShadow.vue";
import DeleteConfirmation from "@/Components/Fragments/DeleteConfirmation.vue";
import Badge from "@/Components/Elements/Badge.vue";
import { getTypeByBoolean, getText } from "@/Utils";

const props = defineProps({
    rows: Object,
    filters: Object,
});


// Delete modal
const postForm = ref({});
const isDeleteOpen = ref(false);
const openDeleteModal = (post) => {
    postForm.value = post;
    isDeleteOpen.value = true;
};
const closeDeleteModal = () => {
    postForm.value = {};
    isDeleteOpen.value = false;
};

const selectedRow = ref({
    is_all: false,
    selected_ids: [],
});

watch(
    () => selectedRow.value.is_all,
    (newVal) => {
        if (newVal)
            selectedRow.value.selected_ids = props.rows.data.map(
                (user) => user.id
            );
        else selectedRow.value.selected_ids = [];
    }
);

const sortKey = ref(props.filters?.sort_key || "");
const sortOrder = ref(props.filters?.sort_order || "");
const isLoading = ref(false);

// Sort function
function sort(key, order) {
    sortKey.value = key;
    sortOrder.value = order;
    const mergedFilters = {
        ...props.filters,
        search: props.filters?.search ?? "",
        entries: props.rows?.meta?.per_page ?? 25,
        sort_key: key,
        sort_order: order,
    };
    const cleanedQueries = Object.fromEntries(
        Object.entries(mergedFilters).filter(
            ([key, value]) => value !== null && value !== "all" && value !== ""
        )
    );
    router.get(route("user.index"), cleanedQueries, {
        onStart: () => (isLoading.value = true),
        onFinish: () => (isLoading.value = false),
    });
}


const headers = [
    {
        columnName: "Name",
        withSorter: true,
        sorterName: "name",
        isLast: false,
    },
    {
        columnName: "Email",
        withSorter: true,
        sorterName: "email",
        isLast: false,
    },
    {
        columnName: "Role",
        withSorter: false,
        textAlign: "text-center",
        isLast: false,
    },
    {
        columnName: "Joined At",
        withSorter: true,
        sorterName: "join_date",
        isLast: false,
    },
    {
        columnName: "Active",
        withSorter: false,
        sorterName: "attributes",
        isLast: false,
    },
    {
        columnName: "Action",
        withSorter: false,
        textAlign: "text-center",
        isLast: true,
    },
];
</script>
<template>
    <MainLayout title="Manage User">
            <ContentBoxShadow>
                <HeaderDatatable :filters="props.filters" :show-button="true" current-route="user.index"
                    button-route="user.create" button-text="New User" :search-query="props.filters?.search"
                    :entries-query="props.rows?.meta?.per_page" />
                <div v-if="isLoading" class="flex items-center justify-center h-16 p-5 bg-gray-100 min-w-screen">
                    <div class="flex space-x-2 animate-pulse">
                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                    </div>
                </div>
                <BodyDatatable v-else>
                    <template #thead>
                        <RowHead>
                            <ColumnHead text-align="center">
                                <Checkbox name="checkall" v-model:checked="selectedRow.is_all" />
                            </ColumnHead>
                            <template v-for="head in headers">
                                <ColumnHead v-if="head.withSorter" :column-name="head.columnName" :with-sorter="true"
                                    :sorter-name="head.sorterName" :sort-key="sortKey" :sort-order="sortOrder"
                                    @sort="sort" :is-last="head.isLast" />
                                <ColumnHead v-else :text-align="head.textAlign" :is-last="head.isLast">
                                    {{ head.columnName }}
                                </ColumnHead>
                            </template>
                        </RowHead>
                    </template>
                    <template #tbody>
                        <NoDataAvailableRow v-if="
                            props.rows.data === undefined ||
                            props.rows.data.length === 0
                        " :column-total="15" />
                        <RowBody v-else v-for="(row, index) in props.rows.data"
                            :route-name="route('user.edit', row.id)" :row-id="row.id">
                            <ColumnBody>
                                <div class="w-full flex justify-center items-center">
                                    <Checkbox name="id" v-model:checked="selectedRow.selected_ids
                                        " :value="row.id" />
                                </div>
                            </ColumnBody>
                            <ColumnBody>
                                <div>
                                <p class="text-sm text-contentc font-semibold">{{ row.name }}</p>
                                 <small class="text-xs italic uppercase text-contentc">{{ row.initial_name !== null && row.initial_name !== '' ? `(${row.initial_name})` : '' }}</small>
                                </div>
                            </ColumnBody>
                            <ColumnBody>
                                {{ row.email }}
                            </ColumnBody>
                            <ColumnBody>
                                {{ row.roles[0] }}
                            </ColumnBody>
                            <ColumnBody>
                                {{ row.join_date_formated }}
                            </ColumnBody>
                            <ColumnBody>
                                <Badge :type="getTypeByBoolean(row.is_active)" :text="getText(row.is_active)" />
                            </ColumnBody>
                            <ColumnBody :is-last="true" text-align="text-center">
                                <div class="flex flex-row justify-center space-x-1">
                                    <EditIconButton :route-name="route('user.edit', row.id)" />
                                    <DeleteIconButton :is-link="false" @event="openDeleteModal(row)" />
                                </div>
                            </ColumnBody>
                        </RowBody>
                    </template>
                </BodyDatatable>
                <FooterDatatable v-if="props.rows?.links !== undefined" :pagination="props.rows" />
            </ContentBoxShadow>
        <DeleteConfirmation :is-delete-open="isDeleteOpen" :data="postForm" @close-delete-modal="closeDeleteModal"
            route-name="user.destroy" />
    </MainLayout>
</template>
