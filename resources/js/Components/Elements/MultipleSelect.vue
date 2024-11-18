<script setup>
import { computed, ref } from "vue";

const props = defineProps({
    options: {
        type: Array,
        default: [],
    },
});

const isOpen = ref(false);
const handleOpen = () => {
    isOpen.value = !isOpen.value;
};
const onClickAway = () => {
    isOpen.value = false;
};

const tagsSelected = defineModel({ default: [] });

const handleSelection = (tagId) => {
    const tagIndex = tagsSelected.value.indexOf(tagId);
    tagIndex !== -1
        ? tagsSelected.value.splice(tagIndex, 1)
        : tagsSelected.value.push(tagId);
};

const getDisplayName = (tagId) => {
    const { display_name } = props.options.find((tag) => tag.id === tagId);
    return display_name;
};

const search = ref("");
const tagOptions = computed(() => {
    if (search.value === "" || search.value === null) return props.options;
    return props.options.filter((tag) =>
        tag.displayName.toLowerCase().includes(search.value.toLowerCase())
    );
});
</script>
<template>
    <div class="relative" v-click-away="onClickAway">
        <div class="w-full">
            <div
                class="my-2 flex rounded bg-white p-2 border border-gray-400 focus:border-indigo-500 focus:ring-indigo-500"
            >
                <div class="flex flex-auto flex-wrap">
                    <div
                        v-for="tag in tagsSelected"
                        :key="tag"
                        @click="handleSelection(tag)"
                        class="flex justify-center items-center my-1 mr-1 font-medium py-1 px-2 bg-blue-50 rounded-full text-primary border border-primary hover:text-red-600 hover:bg-red-50 hover:border-red-600"
                    >
                        <div
                            class="text-xs font-normal leading-none max-w-full flex-initial"
                        >
                            {{ getDisplayName(tag) }}
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
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <input
                            placeholder="type to search"
                            v-model="search"
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
                    v-for="tag in tagOptions"
                    :key="tag.id"
                    @click="handleSelection(tag.id)"
                    class="cursor-pointer w-full border-gray-100 border-b"
                >
                    <div
                        class="flex w-full items-center p-2 pl-2 border-l-4 relative"
                        :class="
                            tagsSelected.includes(tag.id)
                                ? 'border-primary hover:bg-red-50'
                                : 'border-transparent hover:bg-gray-200'
                        "
                    >
                        <div class="w-full items-center flex justify-between">
                            <div class="mx-2 leading-6">
                                {{ tag.display_name }}
                            </div>
                            <div
                                class="text-xs italic leading-6"
                                :class="
                                    tag.isActive
                                        ? 'text-green-500'
                                        : 'text-red-500'
                                "
                            >
                                {{
                                    tag.isActive === true
                                        ? "active"
                                        : "non-active"
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
