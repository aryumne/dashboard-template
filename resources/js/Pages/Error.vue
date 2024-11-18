<template>
    <div class="h-screen w-screen bg-gray-50 flex items-center">
        <div
            class="container flex flex-col md:flex-row items-center justify-between px-5 text-gray-700"
        >
            <div class="w-full lg:w-1/2 mx-8">
                <div
                    class="text-7xl text-blue-500 font-dark font-extrabold mb-8"
                >
                    {{ title }}
                </div>
                <p class="text-2xl md:text-3xl font-light leading-normal mb-8">
                    {{ description }}
                </p>

                <Link
                    :href="route('dashboard')"
                    class="px-5 inline py-3 text-sm font-medium leading-5 shadow-2xl text-white transition-all duration-400 border border-transparent rounded-lg focus:outline-none bg-blue-600 active:bg-gray-600 hover:bg-gray-700"
                    >back to dashboard</Link
                >
            </div>
            <div class="w-full lg:flex lg:justify-end lg:w-1/2 mx-5 my-12">
                <img
                    src="https://user-images.githubusercontent.com/43953425/166269493-acd08ccb-4df3-4474-95c7-ad1034d3c070.svg"
                    class=""
                    alt="Page not found"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    status: {
        type: Number,
        default: 404,
    },
});

const title = computed(() => {
    return {
        503: "503: Service Unavailable",
        500: "500: Server Error",
        404: "404: Page Not Found",
        403: "403: Forbidden",
    }[props.status];
});
const description = computed(() => {
    return {
        503: "Sorry, we are doing some maintenance. Please check back soon.",
        500: "Whoops, something went wrong on our servers.",
        404: "Sorry, the page you are looking for could not be found.",
        403: "Sorry, you are forbidden from accessing this page.",
    }[props.status];
});
</script>
