<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";

const app = usePage().props.app;

onMounted(() => {
    const darkMode = localStorage.getItem("theme") == 1 ? true : false;
    darkMode === true
        ? document.documentElement.classList.add("dark")
        : document.documentElement.classList.remove("dark");
});
</script>

<template>
    <div class="relative min-h-screen flex flex-col justify-center items-center bg-bgc-1 px-4 overflow-hidden">
        <div class="absolute top-0 right-0 w-0 h-0 border-t-[100vh] border-t-bgc-1 border-r-[100vw] border-r-primary">
        </div>
        <div class="z-10 -mt-14">
            <Link href="/">
            <img class="h-16 md:h-20 fill-current" :src="app.brand_logo" />
            </Link>
        </div>
        <div class="z-10 w-full sm:max-w-md mt-8 px-6 py-4 bg-boxc shadow-lg overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
<style>
input:focus {
    outline: none !important;
    box-shadow: none !important;
    /* Menghapus shadow yang mungkin ditambahkan oleh browser */
}
</style>
