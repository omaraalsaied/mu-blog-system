<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import FileInput from "@/Components/FileInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from 'vue';

const form = useForm({
    title: "",
    body: "",
    images: ref([])
});

const submit = () => {
    form.post(route("posts.store"));
};

const addPhotos = (event) => {
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = () => {
            form.images.push({
                id: null,
                url: reader.result,
                file: file
            });
        };
        reader.readAsDataURL(file);
    }
};

const deleteImage = async (index) => {
    form.images.splice(index, 1);
};
</script>

<template>
    <Head title="Blog Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Blog Create
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="title" value="Title" />

                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.title"
                                />
                            </div>

                            <div class="my-6">
                                <label
                                    for="body"
                                    class="block mb-2 text-sm font-medium text-gray-900"
                                >Body</label
                                >
                                <textarea
                                    type="text"
                                    v-model="form.body"
                                    name="content"
                                    id=""
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                ></textarea>

                                <div
                                    v-if="form.errors.body"
                                    class="text-sm text-red-600"
                                >
                                    {{ form.errors.body }}
                                </div>
                            </div>

                            <div>
                                <div class="my-6">
                                    <label for="images" class="block mb-2 text-sm font-medium text-gray-900">Images</label>
                                    <input type="file" class="form-control" multiple @change="addPhotos">
                                </div>
                            </div>

                            <div v-if="form.images.length > 0" class="text-sm text-red-600">
                                <div v-for="(img, index) in form.images" :key="index" class="relative inline-block mr-2 mb-2">
                                    <button @click="deleteImage(index)" class="absolute top-0 right-0 text-red-600 bg-white p-1 rounded-full">
                                        <svg class="w-4 h-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                    <img :src="img.url" class="w-32 h-auto rounded-lg" alt="Image"/>
                                </div>
                            </div>

                            <PrimaryButton
                                type="submit"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Submit
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
