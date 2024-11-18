<script setup>
import NavItem from "@/Components/Fragments/NavItem.vue";
import { ref } from "vue";
import { hasAccess } from "@/Utils";
import { usePage, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";

const auth = usePage().props.auth;

defineProps({
    isOpen: {
        require: true,
        type: Boolean,
    },
    isExpanded: {
        require: true,
        type: Boolean,
    },
});
defineEmits(["handleOpenSidebar", "handleOpenDropdown"]);
const isHovered = ref(false)
const menus = ref([
    {
        displayName: "Dashboard",
        routeName: "dashboard",
        activeRouteName: "dashboard",
        icon: "house-laptop",
        type: "link",
        allowPermissions: [],
    },
    // {
    //     displayName: "File Manager",
    //     routeName: "filemanager",
    //     activeRouteName: "filemanager",
    //     icon: "file-image",
    //     type: "link",
    //     allowPermissions: [],
    // },
    {
        displayName: "Settings",
        routeName: "-",
        icon: "-",
        type: "group",
        allowPermissions: ["manage user", "manage role", "all activities"],
    },
    {
        displayName: "Manage User",
        routeName: "user.index",
        activeRouteName: "user.*",
        icon: "users-gear",
        type: "link",
        allowPermissions: ["manage user"],
    },
    {
        displayName: "Manage Role",
        routeName: "role.index",
        activeRouteName: "role.*",
        icon: "user-gear",
        type: "link",
        allowPermissions: ["manage role"],
    },
    {
        displayName: "Activity Log",
        routeName: "activity.index",
        activeRouteName: "activity.index",
        icon: "clock-rotate-left",
        type: "link",
        allowPermissions: ["all activities"],
    },
]);
</script>
<template>
    <aside id="sidebar"
        class="flex-none z-20 h-full transition-all w-16 duration-500 ease-in-out shadow-lg bg-boxc pt-5 pb-4 hover:w-56"
        :class="[isOpen && 'w-56']"
        @mouseover="isHovered = true"
        @mouseleave="isHovered = false"
        aria-label="Sidebar">
            <div class="h-full overflow-y-auto px-3">
                    <ul class="space-y-1 pb-2">
                        <li v-for="menu in menus" :key="menu.routeName">
                            <div v-if="
                                hasAccess(
                                    auth.permissions,
                                    menu.allowPermissions
                                )
                            ">
                                <NavItem v-if="menu.type === 'link'" :route-name="menu.routeName" :is-show="isOpen || isHovered"
                                    :active-route-name="menu.activeRouteName" :menu-name="menu.displayName">
                                    <template #svgIcon>
                                        <div class="w-4 h-4 text-center text-md transition duration-75">
                                            <font-awesome-icon :icon="menu.icon" />
                                        </div>
                                    </template>
                                </NavItem>
                                <div v-else-if="menu.type === 'dropdown'">
                                    <button
                                        class="flex items-center space-x-2 justify-left w-full text-contentc text-sm p-2 rounded-lg hover:bg-primary/30 hover:text-primary whitespace-nowrap"
                                        :class="{ 'bg-primary/30': menu.isOpen }" @click="menu.isOpen = !menu.isOpen">
                                            <div class="w-4 h-4 text-center text-md transition duration-75">
                                                <font-awesome-icon :icon="menu.icon" />
                                            </div>
                                            <span class="ml-3" v-if="isOpen || isHovered">{{ menu.displayName }}</span>
                                            <font-awesome-icon  v-if="isOpen || isHovered"
                                            :icon="['fas', menu.isOpen ? 'chevron-up' : 'chevron-down']" />
                                    </button>
                                    <transition enter-active-class="transition ease-out duration-200"
                                        enter-from-class="opacity-0 transform -translate-y-2"
                                        enter-to-class="opacity-100 transform translate-y-0"
                                        leave-active-class="transition ease-in duration-150"
                                        leave-from-class="opacity-100 transform translate-y-0"
                                        leave-to-class="opacity-0 transform -translate-y-2">
                                        <ul v-if="menu.isOpen " class="pl-4 mt-1 space-y-1">
                                            <li v-for="(item, i) in menu.menuItems" :key="i">
                                                <NavItem :route-name="item.routeName" :is-show="isOpen || isHovered"
                                                    :active-route-name="item.activeRouteName"
                                                    :menu-name="item.displayName" :initial-name="item.initialName" :is-sub-menu="true">
                                                </NavItem>
                                            </li>
                                        </ul>
                                    </transition>
                                </div>
                               <div  v-else>
                                 <p v-if="isOpen || isHovered" class="text-secondary text-xs pt-2 pb-1 pl-3 uppercase font-bold tracking-wider">
                                    {{ menu.displayName }}
                                </p>
                               </div>
                            </div>
                        </li>
                        <li>
                            <Link :href="route('logout')" method="post" as="button" class="flex w-full mt-4">
                            <PrimaryButton class="w-full flex justify-center">
                                <p v-if="isOpen || isHovered" class="text-xs uppercase">Logout</p>
                                <font-awesome-icon v-else icon="fa-solid fa-right-from-bracket" />
                            </PrimaryButton>
                            </Link>
                        </li>
                    </ul>
            </div>
    </aside>
</template>
