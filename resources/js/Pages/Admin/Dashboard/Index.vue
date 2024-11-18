<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import ContentBoxShadow from "@/Components/Templates/ContentBoxShadow.vue";
import FileInput from "@/Components/Elements/FileInput.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const auth = usePage().props.auth;
const linkDownload = ref(null);

const data = ref({
  file: null,
});

function handleSubmit() {
  const formData = new FormData();
  formData.append('file', data.value.file);

  axios.post(route('convert.word.to.pdf'), formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
    responseType: 'blob',
  })
  .then(response => {
     const blob = response.data;
      const url = window.URL.createObjectURL(new Blob([blob]));
      linkDownload.value = url;

      // Optional: Trigger a download automatically
      const a = document.createElement("a");
      a.href = url;
      a.download = "converted_file.pdf";
      a.click();  
  })
  .catch(error => {
    console.error('Error converting Word to PDF:', error);
  });
}
</script>

<template>
  <MainLayout title="Dashboard">
      <div>
        <ContentBoxShadow>
        <div class="text-center py-8">
          <h1 class="text-highlight text-xl font-bold pb-2">
            Hello, <span class="text-primary">{{ auth.user.name }}!</span>
          </h1>
          <p class="text-contentc">welcome back.</p>
          <form @submit.prevent="handleSubmit">
                <div class="my-8">
                    <FileInput
                            id="file"
                            class="mt-1 block w-full"
                            v-model="data.file"
                            accept=".docx,.doc"
                        />
                </div>
                <div class="mt-6 flex justify-end space-x-2 items-center">
                    <PrimaryButton button-type="submit">
                        Save
                    </PrimaryButton>
                </div>
            </form>
             <a v-if="linkDownload" :href="linkDownload" download="converted_file.pdf">Download PDF</a>
        </div>
      </ContentBoxShadow>
      </div>
  </MainLayout>
</template>
