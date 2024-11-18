<script setup>
import { ref, onBeforeMount, computed, onMounted } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import HeaderMain from "@/Layouts/main-parts/HeaderMain.vue";
import SidebarMain from "@/Layouts/main-parts/SidebarMain.vue";
import FooterMain from "@/Layouts/main-parts/FooterMain.vue";
import Toast from "@/Components/Elements/Toast.vue";

const pageInfo = usePage().props;

defineProps({
    title: {
        type: String,
        required: true,
    },
});

const isOpen = ref(false);
const isExpanded = ref(false);
const darkMode = ref(localStorage.getItem("theme") == 1)

const handleOpenSidebar = () => {
    isOpen.value = !isOpen.value;
};

const handleOpenDropdown = () => {
    isExpanded.value = !isExpanded.value;
};

onBeforeMount(() => {
    darkMode.value === true
        ? document.documentElement.classList.add("dark")
        : document.documentElement.classList.remove("dark");
});

onMounted(() => {
    const dropdownButton = document.getElementById("dropdown-button");
    const dropdownMenu = document.getElementById("dropdown-menu");
    window.addEventListener("click", (event) => {
        if (
            !dropdownButton.contains(event.target) &&
            !dropdownMenu.contains(event.target)
        ) {
            dropdownMenu.classList.add("hidden");
            isExpanded.value = false;
        }
    });
})

const toastType = computed(() => {
    if (usePage().props.flash.success) return "success";
    if (usePage().props.flash.failed) return "failed";
    return "info";
});

const flashMessage = computed(() => {
    const { flash } = usePage().props;
    return flash.info || flash.success || flash.failed;
});

const idMessage = computed(() => {
    const { flash } = usePage().props;
    return flash.id;
});

const hasFlashMessage = computed(() => {
    return (
        usePage().props.flash.info ||
        usePage().props.flash.success ||
        usePage().props.flash.failed
    );
});
</script>
<template>
    <Head :title="title" />
    <div class="h-screen flex flex-col">
        <HeaderMain
            :is-open="isOpen"
            :is-expanded="isExpanded"
            :dark-mode="darkMode"
            :app-info="pageInfo.app"
            @handle-open-sidebar="handleOpenSidebar"
            @handle-open-dropdown="handleOpenDropdown"
        />
        <div class="flex flex-1 lg:overflow-hidden bg-bgc-1">
            <SidebarMain :is-open="isOpen" />
            <!-- <div
                :class="{
                    'bg-gray-900 opacity-50 fixed inset-0 z-10 lg:hidden':
                        isOpen,
                    hidden: !isOpen,
                }"
                id="sidebarBackdrop"
                @click="handleOpenSidebar"
            ></div> -->
             <div
                class="flex flex-col flex-1 bg-bgc-1 overflow-y-auto lg:overflow-x-hidden"
            >
                <main class="w-full p-4 flex flex-col flex-1 overflow-hidden">
                    <slot />
                    <Toast
                        v-if="hasFlashMessage"
                        :message="flashMessage"
                        :type="toastType"
                        :key="`${flashMessage}-${idMessage}`"
                    />
                </main>

                <FooterMain :app-info="pageInfo.app" />
            </div>
        </div>
    </div>
</template>
<style>
input:focus {
    outline: none !important;
    box-shadow: none !important;
    /* Menghapus shadow yang mungkin ditambahkan oleh browser */
}

.transition-transform {
  transition: margin-left 0.3s ease-in-out;
}
</style>
