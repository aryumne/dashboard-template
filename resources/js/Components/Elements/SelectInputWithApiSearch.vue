<script setup>
import { ref, watch, computed, nextTick, onMounted } from "vue";
import Loading from "./Loading.vue";
import vueDebounce from "vue-debounce";

const props = defineProps({
    id: String,
    routeName: {
        type: String,
        required: true,
    },
    modelValue: {
        type: [String, Boolean, null],
        default: "",
    },
    placeholder: {
        type: String,
        default: "Choose ...",
    },
    isDisabled: {
        type: Boolean,
        default: false,
    },
    customSize: {
        type: String,
        default: "p-2 text-sm",
    },
    withMarker: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["update:modelValue"]);

const vDebounce = vueDebounce({ lock: true });
const isOpen = ref(false);
const selectedOpt = ref("");
const searchQuery = ref("");
const searchInput = ref(null);
const options = ref([])
const isLoading = ref(false)

const optSelected = computed(() => {
    if (options.value && props.modelValue !== "") {
        if (props.modelValue !== "" && selectedOpt.value == "")
            selectedOpt.value = props.modelValue;
        return (options.value.find((opt) => opt.id === selectedOpt.value) || {})
            .display_name;
    }
    return props.placeholder;
});

const loadOptions = async (val, e) => {
    if (val === undefined || val === null) val = "";
    try {
        isLoading.value = true
        const res = await axios.get(route(props.routeName), {
               params: {
                   search: searchQuery.value,
               },
           });
       if (res.status === 200) options.value = res.data.data;
    } catch (e) {
        console.error(e.message)
    } finally {
        isLoading.value = false
    }
};

onMounted(loadOptions)
const handleOpen = () => {
    isOpen.value = !isOpen.value;
};

const handleSelect = (val) => {
    emit("update:modelValue", val);
    selectedOpt.value = val;
    isOpen.value = false;
};

const onClickAway = () => {
    isOpen.value = false;
};

watch(isOpen, (newVal) => {
    if (newVal === true) {
        nextTick(() => {
            searchInput.value?.focus();
        });
    }
});
</script>

<template>
    <div v-click-away="onClickAway" class="relative w-full">
        <button
            @click.prevent="handleOpen"
            :class="[{ 'ring-primary': isOpen }, customSize, isDisabled === true ? 'cursor-not-allowed': 'cursor-pointer']"
            :disabled="isDisabled"
            class="flex w-full items-center justify-between rounded bg-transparent text-contentc border border-gray-400 focus:border-primary focus:ring-primary disabled:bg-secondary/30"
        >
            <span>{{ optSelected }}</span>
            <font-awesome-icon :icon="isOpen ? 'angle-up' : 'angle-down'" />
        </button>

        <div
            v-show="isOpen"
            class="absolute z-20 w-full mt-1 bg-bgc-1 text-contentc rounded ring-1 ring-gray-300"
        >
            <div class="p-2">
                <input
                    ref="searchInput"
                    :id="`search_${props.id}`"
                    type="text"
                    v-debounce:500="loadOptions"
                    v-model="searchQuery"
                    placeholder="Search by colorway ID or colorway name"
                    :class="[customSize]"
                    class="w-full bg-transparent border border-gray-400 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                />
            </div>
            <div v-if="isLoading">
                <Loading />
            </div>
            <div v-else>
            <ul class="max-h-56 overflow-auto">
                <li
                    v-if="options.length > 0"
                    v-for="opt in options"
                    :key="opt.id"
                    class="cursor-pointer select-none pl-3 border-b border-b-secondary/30 hover:bg-secondary/30"
                    :class="[customSize]"
                    @click="handleSelect(opt.id)"
                >
                    <div class="flex space-x-2 items-center">
                        <p>{{ opt.display_name }}</p>
                    </div>
                </li>
                <li
                    v-else
                    class="cursor-pointer text-center select-none pl-3 border-b border-b-secondary/30 hover:bg-secondary/30"
                    :class="[customSize]"
                >
                    Not Found!
                </li>
            </ul>
            </div>
        </div>
    </div>
</template>
