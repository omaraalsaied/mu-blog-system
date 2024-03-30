<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },

    posts: {
        type: Object,
        default: ({})
    }
});
</script>

<template>
    <Head title="Blog" />

    <div
        class="relative sm:grid sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100  selection:bg-red-500 selection:text-white"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">



            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>


        </div>


        <div class="mt-auto p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-10">
            <div v-for="post in posts" :key="post.id" class="rounded overflow-hidden shadow-lg bg-white mt-auto mb-auto">
                <a href="#">
                    <div  class="w-full">
                        <img v-if="post.post_images.length > 0 && post.post_images[0].post_image_path"
                         :src="'storage/'+post.post_images[0].post_image_path"
                          alt="post image"
                           class=" appearance-none w-20 sm:w-64 lg:w-48 mt-auto">

                    </div>
                </a>
                <div class="p-5">
                <Link :href="route('posts.show', post.id)">
                    <h5 class="font-bold text-xl mb-2">{{ post.title }}</h5>
                            </Link>
                <p class="text-gray-700 text-base mb-5" v-if="post.body.length > 120">{{ post.body.substring(0,120) + "..." }}</p>
                <p class="text-gray-700 text-base mb-5" v-else>{{ post.body }}</p>

                <h5 class="font text-ls mb-2"> Written By: <h5 class="font-bold text-ls mb-2"> {{ post.user.name }}</h5> </h5>

                <div class="px-6 pt-4 pb-2 text-left  mt">
                    <Link :href="route('posts.show', post.id)">
                                <PrimaryButton class="bg-blue-500 p-2">Read More</PrimaryButton>
                            </Link>
                </div>

                </div>
            </div>
    </div>

    </div>
</template>

<style>

</style>
