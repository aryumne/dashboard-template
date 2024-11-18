<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/Elements/InputLabel.vue";
import TextInput from "@/Components/Elements/TextInput.vue";
import InputError from "@/Components/Elements/InputError.vue";
import ContentBoxShadow from "@/Components/Templates/ContentBoxShadow.vue";
import SelectInput from "@/Components/Elements/SelectInput.vue";
import ToggleSwitch from "@/Components/Elements/ToggleSwitch.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import SecondaryButton from "@/Components/Elements/SecondaryButton.vue";
import TextHeading from "@/Components/Elements/TextHeading.vue";
import DatetimeInput from "@/Components/Elements/DatetimeInput.vue";

defineProps({
    roles: Object,
});
const userForm = useForm({
    name: "",
    initial_name: "",
    email: "",
    is_active: true,
    profile_pict: null,
    role: "",
    join_date: "",
    description: "",
    job: "",
});

const handleSubmit = () => {
    userForm.post(route("user.store"), {
        onSuccess: () => {
            userForm.reset();
        },
    });
};
</script>
<template>
    <MainLayout title="New User">
            <TextHeading title="New USER" />
            <div class="flex justify-center overflow-auto">
            <form @submit.prevent="handleSubmit" class="basis-full md:basis-2/3 lg:basis-3/5">
                    <ContentBoxShadow title="User Form" >
                        <div class="my-6">
                            <div>
                                <InputLabel
                                    for="role"
                                    value="Role"
                                    :is-required="true"
                                />
                                <SelectInput
                                    id="role"
                                    class="mt-1 block w-full"
                                    v-model="userForm.role"
                                    :options="roles.data"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="userForm.errors.role"
                                />
                            </div>
                            <div class="mt-4">
                                <InputLabel
                                    for="name"
                                    value="Name"
                                    :is-required="true"
                                />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="userForm.name"
                                    required
                                />
                                <InputError
                                    class="mt-2"
                                    :message="userForm.errors.name"
                                />
                            </div>
                            <div class="mt-4">
                                <InputLabel
                                    for="initial_name"
                                    value="Initial Name"
                                />
                                <TextInput
                                    id="initial_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="userForm.initial_name"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="userForm.errors.initial_name"
                                />
                            </div>
                            <div class="mt-4">
                                <InputLabel
                                    for="email"
                                    value="Email"
                                    :is-required="true"
                                />
                                <TextInput
                                    id="email"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="userForm.email"
                                    required
                                />
                                <InputError
                                    class="mt-2"
                                    :message="userForm.errors.email"
                                />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="join_date" value="Joined at" />
                                <DatetimeInput
                                    v-model="userForm.join_date"
                                    class="mt-1 block w-full"
                                    :with-time="false"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="userForm.errors.join_date"
                                />
                            </div>
                            <div class="mt-4">
                                <ToggleSwitch
                                    v-model="userForm.is_active"
                                    label="Active"
                                />
                            </div>
                        </div>
                        <p class="my-2 text-sm text-secondary">
                            Default password:
                            <strong class="text-lg">password</strong>
                        </p>
                        <div class="flex space-x-2 items-center">
                            <Link :href="route('user.index')">
                                <SecondaryButton
                                    :class="{
                                        'opacity-25': userForm.processing,
                                    }"
                                    :disabled="userForm.processing"
                                >
                                    Discard
                                </SecondaryButton>
                            </Link>
                            <PrimaryButton
                                button-type="submit"
                                :class="{
                                    'opacity-25': userForm.processing,
                                }"
                                :disabled="userForm.processing"
                            >
                                Save
                            </PrimaryButton>
                        </div>
                    </ContentBoxShadow>
            </form>
            </div>
    </MainLayout>
</template>

<style>
input:focus {
    outline: none !important;
    box-shadow: none !important;
}
</style>
