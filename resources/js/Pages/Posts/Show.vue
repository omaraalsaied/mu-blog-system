<script setup>
   import { Head, Link,useForm } from '@inertiajs/vue3';
   import { Swiper, SwiperSlide } from 'vue-awesome-swiper';
   import 'swiper/swiper-bundle.css';
   import { ref } from 'Vue';
   import TextInput from "@/Components/TextInput.vue";
   import PrimaryButton from "@/Components/PrimaryButton.vue";
   import { onMounted } from 'vue';
   import axios from 'axios';

   const { post, canLogin, canRegister } = defineProps({
       canLogin: Boolean,
       canRegister: Boolean,
       post: Object
   });

   const form = useForm({
       body: "",
       post_id: post.id
   });

   const submit = () => {
        form.post(route("comment.store"));
        form.post = "";
   };


const showDropdown = ref([]);

function toggleDropdown(index) {
  showDropdown.value[index] = !showDropdown.value[index];
}

const editingCommentIndex = ref(null);
const editedComment = ref('');


function editComment(index) {

        editingCommentIndex.value = index;
        editedComment.value = index.body;
    toggleDropdown(index);


}

function findCommentById(commentId) {
  return post.comments.find(comment => comment.id === commentId);
}


async function saveEdit() {
    try {
        const index = editingCommentIndex.value
        console.log(index)
        const commentId = editingCommentIndex.value.id; // Assuming the comment object has an 'id' property
        const updatedCommentData = {
            body: editedComment.value,
            id: editingCommentIndex.value.id
        };

            const response = await axios.patch(`/comments/${commentId}`, updatedCommentData);

            if (response.status === 200) {

            const commentToUpdate = findCommentById(commentId);
            commentToUpdate.body = editedComment.value;


            // Reset editing variables
            editingCommentIndex.value = null;
            editedComment.value = '';
            } else {
            console.error('Unexpected response from server:', response);
            }

    } catch (error) {
        console.error('Error updating comment:', error);
    }
}

// Cancel editing
function cancelEdit() {
    editingCommentIndex.value = null;
    editedComment.value = '';
}

async function deleteComment(index) {
    try{
    await axios.delete(`/comments/${index.id}`);
        post.comments.splice(index, 1);
    } catch (err) {
        console.error(err);
    }
}


   const swiperOptions = {
     loop: true,
     autoplay: {
       delay: 1000,
     },
   };

   onMounted(() => {
    document.addEventListener('click', closeDropdownOnClickOutside);
});

function closeDropdownOnClickOutside(event) {
    showDropdown.value.forEach((value, index) => {
            const button = event.target.closest('.relative').querySelector('button');
            if (button !== event.target && !button.contains(event.target)) {
                showDropdown.value[index] = false;
            }
        });
}


</script>
<template>
   <Head title="Post" />
      <div
         class="relative sm:grid sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100  selection:bg-red-500 selection:text-white"
         >
         <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link
               v-if="$page.props.auth.user"
               :href="route('dashboard')"
               class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
               >
            Dashboard</Link
               >
            <template v-else>
               <Link
                  :href="route('login')"
                  class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >
               Log in</Link
                  >
               <Link
                  v-if="canRegister"
                  :href="route('register')"
                  class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                  >
               Register</Link
                  >
            </template>
            <Link
               :href="route('index')"
               class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
               >
            Home</Link
               >
         </div>
         <main class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white dark:bg-blue-500 antialiased">
            <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
               <article class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                  <header class="mb-4 lg:mb-6 not-format">
                     <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white"> {{ post.title }}</h1>
                  </header>
                  <swiper :options="swiperOptions">
                     <swiper-slide v-for="(image, index) in post.post_images" :key="index">
                        <img :src="'/storage/' + image.post_image_path.replace('/posts/{{ form.post.id }}', '')" alt="Post Images">
                     </swiper-slide>
                  </swiper>
                  <address class="flex items-center mb-6 not-italic">
                     <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white mt-4">
                        <div>
                           <p class="text-base text-gray-500 dark:text-gray-900"> Author:</p>
                           <h1 href="#" rel="author" class="text-xl font-bold text-gray-900 dark:text-white">{{ post.user.name }}</h1>
                           <p class="text-base text-gray-500 dark:text-gray-400"> {{ post.created_at }}</p>
                        </div>
                     </div>
                  </address>
                  <p class="font-semibold mt-4"> {{ post.body }}</p>
                  <section class="not-format mt-8">
                     <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion ({{ post.comments.length }})</h2>
                     <template v-if="$page.props.auth.user">
                        <form @submit.prevent="submit" class="mt-4">
                           <div class="flex space-x-4">
                              <TextInput
                                 id="body"
                                 type="text"
                                 class="mt-1 block w-full"
                                 v-model="form.body"
                                 required
                                 autofocus
                                 />
                              <PrimaryButton
                                 type="submit"
                                 :class="{ 'opacity-25': form.processing }"
                                 :disabled="form.processing"
                                 >
                                 Submit
                              </PrimaryButton>
                           </div>
                        </form>
                     </template>
                     <div v-else>
                        <p class="text-white mt-4 font-black">You must be logged in to comment.</p>
                        <Link :href="route('login')" class="ms-4  mt-4 mr-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >

                        Log in</Link> or
                        <Link :href="route('register')" class="ms-4 mt-4 mr-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >
                        Register</Link>
                     </div>
                     <div class="mt-6 space-y-6">
                        <div v-for="(comment, index) in post.comments" :key="index" class="bg-white rounded-lg shadow-md dark:bg-gray-900">
                           <div class="p-4 flex justify-between items-center">
                              <div>
                                 <div class="flex items-center mb-2">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ comment.user.name }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 ml-2">{{ comment.created_at }}</p>
                                 </div>
                                 <p class="text-sm text-gray-700 dark:text-gray-300">{{ comment.body }}</p>
                              </div>
                              <div v-if="($page.props.auth.user) && (($page.props.auth.user.id === post.user_id) || ($page.props.auth.user.id === comment.user_id))" class="relative">
                                 <button @click="toggleDropdown(index)" class="text-gray-400 hover:text-gray-700 dark:text-gray-200 dark:hover:text-gray-100 focus:outline-none">
                                    <svg width="16px" height="16px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-three-dots">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                 </button>
                                 <div v-if="showDropdown[index]" class="absolute bottom-0 right-0 mt-2 w-48 bg-white rounded-md shadow-lg dark:bg-gray-800">
                                    <div v-if="($page.props.auth.user.id == comment.user_id)">
                                        <button @click="editComment(comment)" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 hover:text-gray-900 dark:hover:bg-gray-700 dark:hover:text-gray-300 w-full text-left">Edit</button>
                                    </div>
                                    <div v-if="($page.props.auth.user.id == comment.user_id) || ($page.props.auth.user.id === post.user_id)">
                                        <button @click="deleteComment(comment)" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-700 dark:hover:text-red-300 w-full text-left">Delete</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div v-if="editingCommentIndex !== null" class="absolute inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
                            <div class="bg-white p-4 rounded-lg shadow-md">
                                <textarea v-model="editedComment" class="block w-full h-40 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                <div class="mt-2 flex justify-end">
                                    <button @click="cancelEdit" class="mr-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</button>
                                    <button @click="saveEdit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Save</button>
                                </div>
                            </div>
                        </div>

                     </div>
                  </section>
               </article>
            </div>
         </main>
      </div>
</template>
<style>
</style>
