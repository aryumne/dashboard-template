<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link, useForm, router } from "@inertiajs/vue3";
import InputLabel from "@/Components/Elements/InputLabel.vue";
import TextInput from "@/Components/Elements/TextInput.vue";
import InputError from "@/Components/Elements/InputError.vue";
import ContentBoxShadow from "@/Components/Templates/ContentBoxShadow.vue";
import SelectInput from "@/Components/Elements/SelectInput.vue";
import ToggleSwitch from "@/Components/Elements/ToggleSwitch.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import SecondaryButton from "@/Components/Elements/SecondaryButton.vue";
import TextHeading from "@/Components/Elements/TextHeading.vue";
import DangerButton from "@/Components/Elements/DangerButton.vue";
import DatetimeInput from "@/Components/Elements/DatetimeInput.vue";

const props = defineProps({
    roles: Object,
    user: Object,
});
const dataForm = useForm({
    name: props.user.data.name,
    initial_name: props.user.data.initial_name,
    email: props.user.data.email,
    is_active: props.user.data.is_active,
    profile_pict: null,
    role: props.user.data.roles[0],
    join_date: props.user.data.join_date,
});

const handleSubmit = () => {
    router.patch(
        route("user.update", props.user.data.id),
        {
            name: dataForm.name,
            initial_name: dataForm.initial_name,
            email: dataForm.email,
            role: dataForm.role,
            is_active: dataForm.is_active,
            join_date: dataForm.join_date,
        },
        {
            onSuccess: () => {
                dataForm.reset();
                window.location.reload();
            },
        }
    );
};

const handleResetPassword = () => {
    router.patch(
        route("user.update", props.user.data.id),
        {
            password: "password",
        },
        {
            onSuccess: () => {
                dataForm.reset();
            },
        }
    );
};

</script>
<template>
    <MainLayout title="New User">
            <TextHeading title="Edit USER" />
            <div class="flex justify-center overflow-auto">
                <div class="basis-full md:basis-2/3 lg:basis-3/5 space-y-2">
                <ContentBoxShadow title="Edit User Information">
                    <form @submit.prevent="handleSubmit">
                        <div class="my-6">
                            <div>
                                <InputLabel for="role" value="Role" :is-required="true" />
                                <SelectInput id="role" class="mt-1 block w-full" v-model="dataForm.role"
                                    :options="props.roles.data" />
                                <InputError class="mt-2" :message="dataForm.errors.role" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="name" value="Name" :is-required="true" />
                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="dataForm.name"
                                    required />
                                <InputError class="mt-2" :message="dataForm.errors.name" />
                            </div>                            
                            <div class="mt-4">
                                <InputLabel for="initial_name" value="Initial Name" />
                                <TextInput id="initial_name" type="text" class="mt-1 block w-full" v-model="dataForm.initial_name" />
                                <InputError class="mt-2" :message="dataForm.errors.initial_name" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="email" value="Email" :is-required="true" />
                                <TextInput id="email" type="text" class="mt-1 block w-full" v-model="dataForm.email"
                                    required />
                                <InputError class="mt-2" :message="dataForm.errors.email" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="join_date" value="Joined at" />
                                <DatetimeInput v-model="dataForm.join_date" class="mt-1 block w-full"
                                    :with-time="false" />
                                <InputError class="mt-2" :message="dataForm.errors.join_date" />
                            </div>
                            <div class="mt-4">
                                <ToggleSwitch v-model="dataForm.is_active" label="Active" />
                            </div>
                        </div>
                        <div class="flex space-x-2 items-center">
                            <Link :href="route('user.index')">
                            <SecondaryButton :disabled="dataForm.processing">
                                Discard
                            </SecondaryButton>
                            </Link>
                            <PrimaryButton button-type="submit" :disabled="dataForm.processing" :is-loading="dataForm.processing">
                                Save
                            </PrimaryButton>
                        </div>
                    </form>
                </ContentBoxShadow>
                <ContentBoxShadow title="Reset Password">
                    <form @submit.prevent="handleResetPassword">
                        <div class="mt-4 flex space-x-2 items-center">
                            <DangerButton button-type="submit" :disabled="dataForm.processing" :is-loading="dataForm.processing">
                                Reset
                            </DangerButton>
                        </div>
                    </form>
                </ContentBoxShadow>
            </div>
            </div>
    </MainLayout>
</template>
