<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import HeaderDatatable from "@/Components/Datatable/HeaderDatatable.vue";
import BodyDatatable from "@/Components/Datatable/BodyDatatable.vue";
import FooterDatatable from "@/Components/Datatable/FooterDatatable.vue";
import ContentBoxShadow from "@/Components/Templates/ContentBoxShadow.vue";
import RowHead from "@/Components/Datatable/RowHead.vue";
import RowBody from "@/Components/Datatable/RowBody.vue";
import ColumnHead from "@/Components/Datatable/ColumnHead.vue";
import ColumnBody from "@/Components/Datatable/ColumnBody.vue";
import NoDataAvailableRow from "@/Components/Datatable/NoDataAvailableRow.vue";
import Badge from "@/Components/Elements/Badge.vue";
import DetailActivity from "./Partials/DetailActivity.vue";
import ActivityFilter from "./Partials/ActivityFilter.vue";
import { getTypeByObject } from "@/Utils";
import { ACTIVITY_EVENT_BADGES } from "@/Configs/Enums";

const props = defineProps({
  rows: Object,
  filters: Object,
  logNames: Array,
  events: Array,
  users: Object,
});

const getAttributeKeysAsString = (attributes) => {
  if (attributes) {
    const attributeKeys = Object.keys(attributes);
    return attributeKeys.map((key) => `'${key}'`).join(", ");
  }
  return "no attribute changes";
};

// Preview modal
const dataForm = ref({});

const isPreviewOpen = ref(false);
const openPreviewModal = (ctg) => {
  dataForm.value = ctg;
  isPreviewOpen.value = true;
};
const closePreviewModal = () => {
  dataForm.value = {};
  isPreviewOpen.value = false;
};

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
  router.get(route("activity.index"), cleanedQueries, {
    onStart: () => (isLoading.value = true),
    onFinish: () => (isLoading.value = false),
  });
}

const headers = [
  {
    columnName: "Created At",
    withSorter: true,
    sorterName: "created_at",
    isLast: false,
  },
  {
    columnName: "Log Name",
    withSorter: true,
    sorterName: "log_name",
    isLast: false,
  },
  {
    columnName: "Event",
    withSorter: true,
    sorterName: "event",
    isLast: false,
  },
  {
    columnName: "Description",
    withSorter: false,
    sorterName: "description",
    isLast: false,
  },
  {
    columnName: "Changed Att",
    withSorter: false,
    sorterName: "attributes",
    isLast: false,
  },
  {
    columnName: "Causer",
    withSorter: true,
    text: "causer_name",
    isLast: true,
  },
];
</script>
<template>
  <MainLayout title="Manage Category">
      <ActivityFilter
        :filters="props.filters"
        :search-query="props.filters?.search"
        :entries-query="props.rows?.meta?.per_page"
        :log-names="props.logNames"
        :events="props.events"
        :users="props.users.data"
      />
      <ContentBoxShadow>
        <HeaderDatatable
          :filters="props.filters"
          current-route="activity.index"
          :search-query="props.filters?.search"
          :entries-query="props.rows?.meta?.per_page"
          :disable-search="true"
        />
        <div
          v-if="isLoading"
          class="flex items-center justify-center h-16 p-5 bg-gray-100 min-w-screen"
        >
          <div class="flex space-x-2 animate-pulse">
            <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
            <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
            <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
          </div>
        </div>
        <BodyDatatable v-else>
          <template #thead>
            <RowHead>
              <template v-for="head in headers">
                <ColumnHead
                  v-if="head.withSorter"
                  :column-name="head.columnName"
                  :with-sorter="true"
                  :sorter-name="head.sorterName"
                  :sort-key="sortKey"
                  :sort-order="sortOrder"
                  @sort="sort"
                  :is-last="head.isLast"
                />
                <ColumnHead v-else :text-align="head.textAlign" :is-last="head.isLast">
                  {{ head.columnName }}
                </ColumnHead>
              </template>
            </RowHead>
          </template>
          <template #tbody>
            <NoDataAvailableRow
              v-if="props.rows?.data === undefined || props.rows?.data.length === 0"
              :column-total="7"
            />
            <RowBody
              v-else
              v-for="row in props.rows.data"
              :route-name="route('product.show', row.id)"
              :row-id="row.id"
              :clickable="false"
              @click="openPreviewModal(row)"
              class="cursor-pointer"
            >
              <ColumnBody>
                {{ row.created_at }}
              </ColumnBody>
              <ColumnBody>
                {{ row.log_name }}
              </ColumnBody>
              <ColumnBody>
                <Badge
                  :type="getTypeByObject(ACTIVITY_EVENT_BADGES, row.event)"
                  :text="row.event"
                />
              </ColumnBody>
              <ColumnBody :no-wrap="false">
                {{ row.description }}
              </ColumnBody>
              <ColumnBody :no-wrap="false">
                {{ getAttributeKeysAsString(row.properties?.attributes) }}
              </ColumnBody>
              <ColumnBody>
                {{ `${row.actor_name} - ${row.actor_role}` }}
              </ColumnBody>
            </RowBody>
          </template>
        </BodyDatatable>
        <FooterDatatable
          v-if="props.rows?.links !== undefined"
          :pagination="props.rows"
        />
      </ContentBoxShadow>
    <DetailActivity
      :is-preview-open="isPreviewOpen"
      :data="dataForm"
      @close-preview-modal="closePreviewModal"
      title="Detail Activity"
    />
  </MainLayout>
</template>

<style scoped>
input:focus {
  outline: none !important;
  box-shadow: none !important;
}
</style>
