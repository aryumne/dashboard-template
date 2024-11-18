<script setup>
import { ref, watch, computed } from "vue";
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import Underline from "@tiptap/extension-underline";
import Image from "@tiptap/extension-image";
import TextAlign from "@tiptap/extension-text-align";
import Youtube from "@tiptap/extension-youtube";
import Link from "@tiptap/extension-link";
import Modal from "@/Components/Templates/Modal.vue";
import InputLabel from "@/Components/Elements/InputLabel.vue";
import TextInput from "@/Components/Elements/TextInput.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import SecondaryButton from "@/Components/Elements/SecondaryButton.vue";
import InputError from "@/Components/Elements/InputError.vue";
import { Color } from "@tiptap/extension-color";
import TextStyle from "@tiptap/extension-text-style";

const props = defineProps({
    modelValue: String,
});

const emit = defineEmits(["update:modelValue"]);

const editor = useEditor({
    content: props.modelValue,
    onUpdate: ({ editor }) => {
        emit("update:modelValue", editor.getHTML());
    },
    extensions: [
        StarterKit.configure({
            bold: {
                HTMLAttributes: {
                    class: "font-black",
                },
            },
            heading: {
                HTMLAttributes: {
                    class: "font-extrablack tracking-wide",
                },
            },
            blockquote: {
                HTMLAttributes: {
                    class: "border-l-4 border-primary pl-4 italic text-gray-600 dark:text-gray-400 bg-secondary/10 py-3",
                },
            },
        }),
        Underline,
        Image.configure({
            HTMLAttributes: {
                class: "h-auto w-full object-cover object-center",
            },
        }),
        TextAlign.configure({
            types: ["heading", "paragraph"],
        }),
        Youtube,
        Link.configure({
            openOnClick: false,
            HTMLAttributes: {
                class: "hover:text-blue-500 hover:underline",
            },
        }),
        Color.configure({
            types: ["textStyle"],
        }),
        TextStyle,
    ],
    editorProps: {
        attributes: {
            class: "border border-gray-400 rounded-b-lg p-4 h-screen overflow-y-auto outline-none prose max-w-none",
        },
    },
});

watch(
    () => props.modelValue,
    (newVal) => {
        newVal === "" && editor.value.commands.clearContent(true);
    }
);

// image
const image = ref({
    src: "",
    alt: "",
});

const openImageModal = ref(false);

function closeImageModal() {
    openImageModal.value = false;
    image.value.src = "";
    image.value.alt = "";
}

const setImageUrl = (url) => {
    image.value.src = url[0].url;
};
const openFileManager = () => {
    window.open(
        "/laravel-filemanager?type=Images",
        "FileManager",
        "width=900,height=600"
    );
    window.SetUrl = setImageUrl;
};

const setImagetoEditor = () => {
    editor.value
        .chain()
        .focus()
        .setImage({ src: image.value.src, alt: image.value.alt })
        .run();
    closeImageModal();
};

// video
const video = ref("");
const openVideoModal = ref(false);
const errorSetVideo = ref("");

function closeVideoModal() {
    openVideoModal.value = false;
    video.value = "";
}

const setVideotoEditor = () => {
    if (video.value === "") {
        errorSetVideo.value = "The url is required!";
        return;
    }
    editor.value.commands.setYoutubeVideo({
        src: video.value,
        width: "100%",
        height: 480,
    });
    closeVideoModal();
};

// link
const link = ref("");
const openLinkModal = ref(false);
const errorSetLink = ref("");

function closeLinkModal() {
    openLinkModal.value = false;
    link.value = "";
}

const setLinktoEditor = () => {
    if (link.value === "") {
        errorSetLink.value = "The url is required!";
        return;
    }
    editor.value
        .chain()
        .focus()
        .extendMarkRange("link")
        .setLink({ href: link.value })
        .run();
    closeLinkModal();
};
const setColor = (event) => {
    const color = event.target.value;
    editor.value.chain().focus().setColor(color).run();
};

const getColor = computed(() => {
    return editor.value.getAttributes("textStyle").color || "#000000";
});
</script>

<template>
    <div class="p-0">
        <section
            v-if="editor"
            class="text-gray-700 bg-white flex items-center flex-wrap gap-x-4 border-t border-l border-r border-gray-400 rounded-t-lg p-4"
        >
            <button
                type="button"
                @click="editor.chain().focus().toggleBold().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('bold') }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-bold" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleItalic().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('italic') }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-italic" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleUnderline().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('underline') }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-underline" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('left').run()"
                :class="{
                    'bg-gray-200 rounded': editor.isActive({
                        textAlign: 'left',
                    }),
                }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-align-left" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('center').run()"
                :class="{
                    'bg-gray-200 rounded': editor.isActive({
                        textAlign: 'center',
                    }),
                }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-align-center" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('right').run()"
                :class="{
                    'bg-gray-200 rounded': editor.isActive({
                        textAlign: 'right',
                    }),
                }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-align-right" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('justify').run()"
                :class="{
                    'bg-gray-200 rounded': editor.isActive({
                        textAlign: 'justify',
                    }),
                }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-align-justify" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setParagraph().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('underline') }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-p" />
            </button>
            <button
                type="button"
                @click="
                    editor.chain().focus().toggleHeading({ level: 1 }).run()
                "
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 1,
                    }),
                }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-heading" />
                <span class="pl-0.5 text-lg font-bold">1</span>
            </button>
            <button
                type="button"
                @click="
                    editor.chain().focus().toggleHeading({ level: 2 }).run()
                "
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 2,
                    }),
                }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-heading" />
                <span class="pl-0.5 text-lg font-bold">2</span>
            </button>
            <div class="rounded">
                <input type="color" @input="setColor" :value="getColor" />
            </div>
            <button
                type="button"
                @click="editor.chain().focus().toggleBulletList().run()"
                :class="{
                    'bg-gray-200 rounded': editor.isActive('bulletList'),
                }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-list-ul" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleOrderedList().run()"
                :class="{
                    'bg-gray-200 rounded': editor.isActive('orderedList'),
                }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-list-ol" />
            </button>
            <button type="button" class="p-1" @click="openLinkModal = true">
                <font-awesome-icon icon="fa-solid fa-link" />
            </button>
            <button
                type="button"
                class="p-1"
                @click="
                    editor
                        .chain()
                        .focus()
                        .extendMarkRange('link')
                        .unsetLink()
                        .run()
                "
            >
                <font-awesome-icon icon="fa-solid fa-link-slash" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleBlockquote().run()"
                :class="{
                    'bg-gray-200 rounded': editor.isActive('blockquote'),
                }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-quote-left" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleCode().run()"
                :class="{ 'bg-gray-200 rounded': editor.isActive('code') }"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-code" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setHorizontalRule().run()"
                class="p-1"
            >
                <font-awesome-icon icon="fa-solid fa-ruler-horizontal" />
            </button>
            <button type="button" class="p-1" @click="openImageModal = true">
                <font-awesome-icon icon="fa-regular fa-image" />
            </button>
            <button type="button" class="p-1" @click="openVideoModal = true">
                <font-awesome-icon icon="fa-solid fa-video" />
            </button>
            <button
                type="button"
                class="p-1 disabled:text-gray-400"
                @click="editor.chain().focus().undo().run()"
                :disabled="!editor.can().chain().focus().undo().run()"
            >
                <font-awesome-icon icon="fa-solid fa-rotate-left" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().redo().run()"
                :disabled="!editor.can().chain().focus().redo().run()"
                class="p-1 disabled:text-gray-400"
            >
                <font-awesome-icon icon="fa-solid fa-rotate-right" />
            </button>
        </section>
        <EditorContent class="bg-white" :editor="editor" />

        <!-- Image Embed Modal -->
        <Modal :show="openImageModal" @close="closeImageModal">
            <div class="p-6">
                <h4 class="text-bold capitalize">Image Properties</h4>
                <button
                    @click.prevent="openFileManager"
                    class="mt-3 bg-gray-400 p-2 rounded w-full"
                >
                    Select Image
                </button>
                <div class="mt-4">
                    <InputLabel for="src" value="source" class="text-xs" />
                    <TextInput
                        id="src"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="image.src"
                        readonly
                    />
                </div>
                <div class="mt-4">
                    <InputLabel
                        for="alt_img"
                        value="Alternative text"
                        class="text-xs"
                    />
                    <TextInput
                        id="alt_img"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="image.alt"
                    />
                </div>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeImageModal">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton class="ms-3" @click="setImagetoEditor">
                        Set Image
                    </PrimaryButton>
                </div>
            </div>
        </Modal>

        <!-- Video Embed Modal -->
        <Modal :show="openVideoModal" @close="closeVideoModal">
            <div class="p-6">
                <h4 class="text-bold capitalize">Video Properties</h4>
                <div class="mt-4">
                    <InputLabel
                        for="src_video"
                        value="Enter Youtube URL"
                        class="text-xs"
                    />
                    <TextInput
                        id="src_video"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="video"
                    />
                    <InputError class="mt-2" :message="errorSetVideo" />
                </div>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeVideoModal">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton class="ms-3" @click="setVideotoEditor">
                        Set Video
                    </PrimaryButton>
                </div>
            </div>
        </Modal>

        <!-- Link Embed Modal -->
        <Modal :show="openLinkModal" @close="closeLinkModal">
            <div class="p-6">
                <h4 class="text-bold capitalize">Video Properties</h4>
                <div class="mt-4">
                    <InputLabel for="link" value="Enter URL" class="text-xs" />
                    <TextInput
                        id="link"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="link"
                    />
                    <InputError class="mt-2" :message="errorSetLink" />
                </div>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeLinkModal">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton class="ms-3" @click="setLinktoEditor">
                        Set Link
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
