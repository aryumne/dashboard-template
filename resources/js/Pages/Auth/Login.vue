<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import LinkText from "@/Components/Elements/LinkText.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import { Head, useForm } from "@inertiajs/vue3";
import FormGroupInput from "@/Components/Fragments/FormGroupInput.vue";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => {
            form.reset({ password: "" });
        },
    });
};
</script>

<template>
    <AuthLayout>

        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="mt-4">
            <FormGroupInput id="email" type="email" label="Email" v-model="form.email" :is-required="true"
                :error-message="form.errors.email" placeholder="jhondoe@pratama.net" />
            <div class="mt-6">
                <FormGroupInput id="password" type="password" label="Password" v-model="form.password"
                    :is-required="true" :error-message="form.errors.password" placeholder="******" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <LinkText :src="route('dashboard')" text="forgot password?" />

                <PrimaryButton button-type="submit" class="ms-4" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </AuthLayout>
</template>
