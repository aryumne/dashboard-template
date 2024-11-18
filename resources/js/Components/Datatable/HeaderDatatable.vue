<script setup>
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import { useForm, Link, router } from "@inertiajs/vue3";
const props = defineProps({
    currentRoute: {
        type: String,
        required: true,
    },
    buttonRoute: {
        type: String,
        required: false,
    },
    showButton: {
        type: Boolean,
        default: false,
    },
    buttonText: [String, null],
    searchQuery: [String, null],
    entriesQuery: [Number, null],
    disableSearch: {
        type: Boolean,
        default: false,
    },
    filters: {
        type: Object,
        default: {},
    },
    placeholder: {
        type: String,
        default: "Search here..."
    }
});
const queries = useForm({
    search: props.searchQuery ?? "",
    entries: props.entriesQuery ?? 25,
});

const resetSearchInput = () => {
    queries.search = "";
    handleQueries();
};


const handleQueries = () => {
    const mergedFilters = { 
        ...props.filters,
        search: queries.search,
        entries: queries.entries,
    };

     const cleanedQueries = Object.fromEntries(
        Object.entries(mergedFilters).filter(
            ([key, value]) => value !== null && value !== "all" && value !== ""
        )
    );
    router.get(route(props.currentRoute), cleanedQueries);
};

</script>

<template>
    <div class="flex justify-between mb-4 items-end sm:items-center">
        <div class="grow flex sm:flex-row space-y-1 sm:space-y-0 flex-col mr-2">
            <div class="flex-none flex flex-row mb-1 sm:mb-0">
                <div class="relative">
                    <select
                        v-model="queries.entries"
                        @change="handleQueries"
                        class="appearance-none h-full border block appearance-none w-full bg-transparent border-secondary text-contentc p-2 pr-8 leading-tight focus:outline-none focus:border-primary focus:ring-primary"
                        :class="{
                            'md:border-r-transparent': !props.disableSearch,
                        }"
                    >
                        <option class="dark:text-gray-800">10</option>
                        <option class="dark:text-gray-800">25</option>
                        <option class="dark:text-gray-800">50</option>
                        <option class="dark:text-gray-800">100</option>
                        <option class="dark:text-gray-800">500</option>
                    </select>
                </div>
            </div>
            <div
                class="shrink w-full md:w-4/12 flex relative"
                v-if="!props.disableSearch"
            >
                <span
                    class="h-full absolute inset-y-0 left-0 flex items-center pl-2"
                >
                    <svg
                        viewBox="0 0 24 24"
                        class="h-4 w-4 fill-current text-gray-500"
                    >
                        <path
                            d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z"
                        ></path>
                    </svg>
                </span>
                <input
                    :placeholder="props.placeholder"
                    v-model="queries.search"
                    @keyup.enter="handleQueries"
                    class="appearance-none border border-secondary border-b pl-8 pr-6 py-2 w-full bg-transparent text-sm placeholder-secondary text-contentc focus:bg-transparent focus:placeholder-secondary focus:text-contentc focus:outline-none focus:border-primary focus:ring-primary"
                />
                <span
                    v-if="queries.search"
                    @click="resetSearchInput"
                    class="h-full absolute inset-y-0 right-0 flex items-center pr-2 text-red-400"
                >
                    <font-awesome-icon icon="fa-solid fa-xmark" />
                </span>
            </div>
        </div>
        <div class="flex-none pb-1 sm:pb-0" v-if="showButton">
            <Link :href="route(props.buttonRoute)">
                <PrimaryButton>
                    {{ props.buttonText }}
                </PrimaryButton>
            </Link>
        </div>
        <div class="flex-none pb-1 sm:pb-0" v-else>
            <slot />
        </div>
    </div>
</template>
<style>
input:focus,
select:focus {
    outline: none !important;
    box-shadow: none !important;
    /* Menghapus shadow yang mungkin ditambahkan oleh browser */
}
</style>
