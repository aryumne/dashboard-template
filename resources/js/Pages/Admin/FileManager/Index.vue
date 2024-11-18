<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import ContentBoxShadow from "@/Components/Templates/ContentBoxShadow.vue";
</script>
<template>
    <MainLayout title="Manage Category">
        <div class="pt-6 px-4">
            <div class="h-dvh pb-32">
                <iframe
                    src="/laravel-filemanager?type=Images"
                    class="w-full h-full overflow-hidden border-0 rounded-lg"
                ></iframe>
            </div>
        </div>
    </MainLayout>
</template>
