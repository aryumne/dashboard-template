<script setup>
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import FilterDatatable from "@/Components/Datatable/FilterDatatable.vue";
import RadioInput from "@/Components/Elements/RadioInput.vue";
import MultipleCheckbox from "@/Components/Elements/MultipleCheckbox.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import SecondaryButton from "@/Components/Elements/SecondaryButton.vue";

const props = defineProps({
    filters: Object,
    searchQuery: [String, null],
    entriesQuery: [Number, null],
});
const queries = useForm({
    sortBy: props.filters?.sortBy ?? "name",
    direction: props.filters?.direction ?? "asc",
    status: props.filters?.status ?? [],
});

const sortByOptions = ref([
    { label: "Name", value: "name" },
    { label: "Email", value: "email" },
]);

const statusOptions = ref([
    { label: "Active", value: 1 },
    { label: "Non Active", value: 0 },
]);

const handleQueries = () => {
    router.get(route("user.index"), {
        search: props.searchQuery ?? "",
        entries: props.entriesQuery ?? 25,
        sortBy: queries.sortBy,
        direction: queries.direction,
        status: queries.status,
    });
};

const handleSort = (direction) => {
    queries.direction = direction;
    handleQueries();
};

const resetFilter = () => {
    queries.sortBy = "name";
    queries.status = [];
    queries.direction = "asc";
    handleQueries();
};
</script>
<template>
    <FilterDatatable v-model:direction="queries.direction" @handle-sort="handleSort">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <RadioInput
                v-model="queries.sortBy"
                label="Sort By Column"
                :options="sortByOptions"
            />
            <MultipleCheckbox
                v-model="queries.status"
                label="Choose status"
                :options="statusOptions"
            />
        </div>
        <div class="mt-4 py-4 flex space-x-2">
            <SecondaryButton
                @click="resetFilter"
                :class="{
                    'opacity-25': queries.processing,
                }"
                :disabled="queries.processing"
            >
                Reset
            </SecondaryButton>
            <PrimaryButton
                @click="handleQueries"
                :class="{
                    'opacity-25': queries.processing,
                }"
                :disabled="queries.processing"
            >
                Apply
            </PrimaryButton>
        </div>
    </FilterDatatable>
</template>
