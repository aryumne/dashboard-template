<script setup>
import InputError from "@/Components/Elements/InputError.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import ImageInputWithPreview from "@/Components/Elements/ImageInputWithPreview.vue";
import { useForm, usePage, router } from "@inertiajs/vue3";
import { GenerateAssetUrl } from "@/Utils";

const user = usePage().props.auth.user;

const form = useForm({
    profile_pict: "",
});

const handleSubmit = () => {
    router.post(
        route("profile.update.picture"),
        {
            _method: "patch",
            profile_pict: form.profile_pict,
        },
        {
            onSuccess: () => {
                window.location.reload;
                form.reset();
            },
        }
    );
};
</script>

<template>
    <section>
        <div class="flex">
            <div class="basis-1/2">
                <header>
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        Profile Picture
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Please upload a square photo for best results. Thank
                        you!
                    </p>
                </header>
                <form @submit.prevent="handleSubmit" class="mt-6 space-y-6">
                    <div>
                        <ImageInputWithPreview
                            id="profile_pict"
                            class="mt-1 block w-full"
                            v-model="form.profile_pict"
                            :is-image="true"
                            :is-avatar="true"
                            button-text="Browse photo"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.profile_pict"
                        />
                    </div>

                    <div class="flex items-center gap-4">
                        <PrimaryButton
                            button-type="submit"
                            :disabled="form.processing"
                            >Save</PrimaryButton
                        >

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p
                                v-if="form.recentlySuccessful"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >
                                Saved.
                            </p>
                        </Transition>
                    </div>
                </form>
            </div>
            <div class="basis-1/2 m-2">
                <div
                    class="flex justify-center items-center bg-gray-50 rounded-lg py-8"
                >
                    <img
                        :src="
                            GenerateAssetUrl(
                                user.profile_pict || 'avatar.jpg',
                                user.profile_pict && true
                            )
                        "
                        :alt="user.name"
                        class="max-h-40 h-full rounded-full"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
