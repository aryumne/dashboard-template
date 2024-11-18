<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import vueDebounce from "vue-debounce";
import { APP_API_URL } from "@/Utils";

const vDebounce = vueDebounce({ lock: true });
const isOpen = ref(false);
const handleOpen = () => {
    isOpen.value = !isOpen.value;
};
const onClickAway = () => {
    isOpen.value = false;
};

const selectedPosts = defineModel({ default: [] });

const handleSelection = (post) => {
    const postIndex = selectedPosts.value.findIndex(
        (item) => item.id === post.id
    );
    postIndex !== -1
        ? selectedPosts.value.splice(postIndex, 1)
        : selectedPosts.value.push(post);
};

const hasSelected = (post) => {
    const postIndex = selectedPosts.value.findIndex(
        (item) => item.id === post.id
    );
    return postIndex !== -1 ? true : false;
};

const options = ref([]);
const loadOptions = async (val, e) => {
    if (val === undefined || val === null) val = "";
    const res = await axios.get(`${APP_API_URL}/posts`, {
        params: {
            search: val,
        },
    });
    if (res.status === 200) options.value = res.data.posts;
};

onMounted(loadOptions);
</script>
<template>
    <div class="relative" v-click-away="onClickAway">
        <div class="w-full">
            <div
                class="block shadow z-2 w-full lef-0 rounded max-h-80 overflow-y-auto rounded"
            >
                <div class="flex flex-col w-full space-y-2">
                    <div
                        v-for="post in selectedPosts"
                        :key="post.id"
                        @click="handleSelection(post)"
                        class="cursor-pointer w-full text-primary bg-primary/10 hover:bg-red-50 hover:text-red-600 py-1"
                    >
                        <div class="flex w-full items-center p-2 pl-2 relative">
                            <div class="w-full items-center flex">
                                <div class="mx-2 text-sm">
                                    {{ post.title }}
                                </div>
                                <div class="flex flex-auto flex-row-reverse">
                                    <div>
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="100%"
                                            height="100%"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-x cursor-pointer rounded-full w-4 h-4 ml-2"
                                        >
                                            <line
                                                x1="18"
                                                y1="6"
                                                x2="6"
                                                y2="18"
                                            ></line>
                                            <line
                                                x1="6"
                                                y1="6"
                                                x2="18"
                                                y2="18"
                                            ></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="my-2 flex rounded bg-white p-2 border border-gray-400 focus:border-indigo-500 focus:ring-indigo-500"
            >
                <div class="flex flex-auto flex-wrap">
                    <div class="flex-1">
                        <input
                            placeholder="type to search"
                            v-debounce:500="loadOptions"
                            @focus="isOpen = true"
                            class="bg-transparent p-1 px-2 !appearance-none !outline-none h-full w-full text-gray-800 border border-transparent focus:ring-0 focus:border-transparent"
                        />
                    </div>
                </div>
                <div
                    class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200"
                >
                    <button
                        type="button"
                        @click="handleOpen"
                        class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none"
                    >
                        <font-awesome-icon
                            :icon="isOpen ? 'angle-up' : 'angle-down'"
                        />
                    </button>
                </div>
            </div>
        </div>
        <div
            v-show="isOpen"
            class="absolute shadow bg-white z-10 w-full lef-0 rounded max-h-80 overflow-y-auto rounded"
        >
            <div class="flex flex-col w-full">
                <div
                    v-for="post in options"
                    :key="post.id"
                    @click="handleSelection(post)"
                    class="cursor-pointer w-full border-gray-100 border-b"
                >
                    <div
                        class="flex w-full items-center p-2 pl-2 border-l-4 relative"
                        :class="
                            hasSelected(post)
                                ? 'border-primary hover:bg-red-50'
                                : 'border-transparent hover:bg-gray-200'
                        "
                    >
                        <div class="w-full items-center flex">
                            <div class="mx-2 leading-6">
                                {{ post.title }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
