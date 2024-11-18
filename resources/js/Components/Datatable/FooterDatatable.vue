<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    pagination: [Object, null],
});
</script>
<template>
    <div
        class="w-full flex flex-wrap sitems-center justify-between"
    >
        <div>
            <p class="text-sm leading-5 text-primary">
                Showing
                <span class="font-medium">{{ pagination?.meta?.from }}</span>
                to
                <span class="font-medium">{{ pagination?.meta?.to }}</span>
                of
                <span class="font-medium">{{ pagination?.meta?.total }}</span>
                results
            </p>
        </div>
        <div>
            <nav class="relative z-0 inline-flex shadow-sm">
                <div>
                    <Link
                        :href="pagination?.links?.first"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-primary bg-transparent text-sm leading-5 font-medium text-primary hover:text-primary/70 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 hover:bg-primary/30"
                        aria-label="Previous"
                    >
                        First
                    </Link>
                </div>
                <div>
                    <Link
                        v-for="(link, index) in pagination?.meta?.links"
                        :key="index"
                        :href="link.url ? link.url : ''"
                        :class="
                            link.active
                                ? 'bg-primary text-gray-100 '
                                : 'bg-transparent text-primary'
                        "
                        class="-ml-px relative inline-flex items-center px-4 py-2 border border-primary text-sm leading-5 font-medium focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-primary active:text-primary transition ease-in-out duration-150 hover:bg-primary/30"
                        v-html="link.label"
                    >
                    </Link>
                </div>
                <div>
                    <Link
                        :href="pagination?.links?.last"
                        class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-primary bg-transparent text-sm leading-5 font-medium text-primary hover:text-primary/70 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 hover:bg-primary/30"
                        aria-label="Next"
                    >
                        Last
                    </Link>
                </div>
            </nav>
        </div>
    </div>
</template>
