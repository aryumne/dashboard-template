<script setup>
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import FilterDatatable from "@/Components/Datatable/FilterDatatable.vue";
import FormGroupSelect from "@/Components/Fragments/FormGroupSelect.vue";
import RangeDateInput from "@/Components/Elements/RangeDateInput.vue";
import MultipleCheckbox from "@/Components/Elements/MultipleCheckbox.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import SecondaryButton from "@/Components/Elements/SecondaryButton.vue";

const props = defineProps({
    filters: Object,
    searchQuery: [String, null],
    entriesQuery: [Number, null],
    logNames: Array,
    events: Array,
    users: Array,
});
const queries = useForm({
    events: props.filters?.events ?? [],
    log_names: props.filters?.log_names ?? [],
    range_date: props.filters?.range_date ?? null,
    causer_id: props.filters?.causer_id ?? "all",
});

const logNameOptions = ref(props.logNames);

const eventOptions = ref(props.events);

const handleQueries = () => {
    let mergedFilters = {}
    if (queries.events.length > 0) mergedFilters = { ...mergedFilters, events: queries.events }
    if (queries.log_names.length > 0) mergedFilters = { ...mergedFilters, log_names: queries.log_names }
    if (queries.range_date !== null && queries.range_date !== "") mergedFilters = { ...mergedFilters, range_date: queries.range_date }
    if (queries.causer_id !== null && queries.causer_id !== "" && queries.causer_id !== "all") mergedFilters = { ...mergedFilters, causer_id: queries.causer_id }
    if (props.searchQuery !== "" || props.searchQuery !== null) mergedFilters = { ...mergedFilters, search: props.searchQuery }
    if (props.entriesQuery !== "" || props.entriesQuery !== null && props.entriesQuery !== 10) mergedFilters = { ...mergedFilters, entries: props.entriesQuery }
    router.get(route("activity.index"), mergedFilters);
};


const resetFilter = () => {
    queries.sortedColumn = "created_at";
    queries.events = [];
    queries.log_names = [];
    queries.sortBy = "desc";
    queries.range_date = null;
    queries.causer_id = "all";
    handleQueries();
};
</script>
<template>
    <FilterDatatable>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <MultipleCheckbox v-model="queries.log_names" label="Choose Log Names" :options="logNameOptions" />
            <MultipleCheckbox v-model="queries.events" label="Choose Events" :options="eventOptions" />
            <div>
                <p class="mb-4 font-semibold text-secondary uppercase text-xs">
                    SELECT CAUSER
                </p>
                <FormGroupSelect :show-label="false" :set-bg-color="true" id="user" label="User"
                    v-model="queries.causer_id" :options="[
                        {
                            id: 'all',
                            display_name: 'All Causers',
                        },
                        ...props.users,
                    ]" :error-message="queries.errors.causer_id" />
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 mt-3">
            <div class="md:col-span-2">
                <p class="font-semibold text-secondary uppercase text-xs">
                    Pick a date range of creation
                </p>
                <RangeDateInput v-model="queries.range_date" class="mt-1 block w-full" />
            </div>
        </div>
        <div class="mt-4 py-4 flex space-x-2">
            <SecondaryButton @click="resetFilter" :class="{
                'opacity-25': queries.processing,
            }" :disabled="queries.processing">
                Reset
            </SecondaryButton>
            <PrimaryButton @click="handleQueries" :class="{
                'opacity-25': queries.processing,
            }" :disabled="queries.processing">
                Apply
            </PrimaryButton>
        </div>
    </FilterDatatable>
</template>
