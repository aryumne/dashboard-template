<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";

const props = defineProps({
    isOpen: {
        require: true,
        type: Boolean,
    },
    isExpanded: {
        require: true,
        type: Boolean,
    },
    darkMode: {
        type: Boolean,
        Required: true,
    },
    appInfo: Object,
});



const isDarkMode = ref(props.darkMode);

const toggleTheme = () => {
    isDarkMode.value = !isDarkMode.value;
    if (isDarkMode.value === true) {
        localStorage.setItem("theme", 1);
        document.documentElement.classList.add("dark");
    } else {
        localStorage.removeItem("theme");
        document.documentElement.classList.remove("dark");
    }
};

defineEmits(["handleOpenSidebar", "handleOpenDropdown"]);
</script>

<template>
    <nav class="bg-boxc shadow border-b border-secondary/30 shadow-md shadow-secondary/10 z-30 w-full">
        <div class="px-3 py-3 pt-4 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <!-- Sidebar toggle -->
                    <button @click.prevent="$emit('handleOpenSidebar')" id="toggleSidebarMobile" aria-expanded="true"
                        aria-controls="sidebar"
                        class="mr-1 text-highlight cursor-pointer p-2 hover:bg-primary/30 active:text-primary focus:bg-bgc-2 focus:ring-2 focus:ring-transparent focus:text-primary rounded">
                        <svg v-if="!props.isOpen" id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <svg v-if="props.isOpen" id="toggleSidebarMobileClose" class="w-6 h-6" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <!-- Brand -->
                    <Link :href="route('dashboard')" class="text-xl font-bold flex items-center lg:ml-2.5">
                    <img :src="appInfo.brand_logo" class="h-8 mr-2" alt="logo" />
                    <span class="self-center whitespace-nowrap text-contentc hover:text-primary">
                    {{ appInfo.brand_name }}
                    </span>
                    </Link>
                </div>
                <!-- Dropdown profile -->
                <div class="flex items-center">
                    <!-- Toggle Theme -->
                    <button @click="toggleTheme" aria-expanded="true" aria-controls="sidebar"
                        class="mr-2 text-highlight hover:text-primary cursor-pointer p-2 focus:bg-transparent focus:ring-0 focus:border-transparent rounded">
                        <svg v-if="isDarkMode" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </button>

                    <div class="relative inline-block text-left">
                        <button id="dropdown-button" type="button" @click="$emit('handleOpenDropdown')"
                            class="inline-flex justify-center w-full px-4 py-2 text-sm text-contentc hover:bg-primary/30 focus:bg-primary/30 bg-transparent border border-transparent rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-transparent font-semibold active:bg-primary/30">
                            {{ $page.props.auth.user.name }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="dropdown-menu" :class="{ hidden: !props.isExpanded }"
                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-boxc ring-1 ring-black ring-opacity-5">
                            <div class="py-3 p-2" role="menu" aria-orientation="vertical"
                                aria-labelledby="dropdown-button">
                                <Link :href="route('profile.edit')"
                                    class="divide-y-4 font-semibold space-y-2 mb-4 block px-4 py-3 mb-1 text-sm text-gray-700 rounded-md bg-transparent hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                My Profile</Link>
                                <Link :href="route('logout')" method="post" as="button" class="flex w-full">
                                <PrimaryButton class="w-full flex justify-center">
                                    Logout
                                </PrimaryButton>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
