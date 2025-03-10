<script setup >
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps(["posts"]);
const fetchPage = (url) =>{
    if (url) {
        router.get(url); // Navigate to the clicked page
    }
}

const formatTime = (date) => {
    return new Intl.DateTimeFormat("en-US", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: true,
    }).format(new Date(date));
};
</script>
<template lang="">
    <div class = "w-10/12 px-4 h-11/12">
        <div class="flex flex-col gap-3 py-4">
            <div class="flex justify-center items-ceneter">
                <button class="px-4 py-3 bg-green-500 rounded-md hover:bg-green-700"> Create Post</button>
            </div>
            <div class="flex flex-grow">
                <table class="min-w-full text-center divide-gray-700 ">
                    <thead class="font-bold bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-gray-900 whitespace-nowrap">#</th>
                            <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Title</th>
                            <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Posted By</th>
                            <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Created At</th>
                            <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="post in props.posts.data" :key="post.id">
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap" >{{post.id}}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap" >{{post.title}}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap" >{{post.user.name}}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap" >{{formatTime(post.created_at)}}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap" >
                                <button class="px-3 py-1 mx-2 text-sm text-white bg-blue-400 rounded-md hover:bg-blue-500"> view</button>
                                <button class="px-3 py-1 mx-2 text-sm text-white bg-blue-500 rounded-md hover:bg-blue-700"> update</button>
                                <button class="px-3 py-1 mx-2 text-sm text-white bg-red-500 rounded-md hover:bg-red-800"> remove</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                        </tr>
                    </tfoot>
                </table>
                <!-- Pagination Links -->
                </div>
                <div class="flex justify-center gap-2 mt-5">
                    <button
                        v-for="(link, index) in posts.links"
                        :key="index"
                        @click="fetchPage(link.url)"
                        v-html="link.label"
                        :class="{'font-bold underline': link.active}"
                        class="px-3 py-1 border rounded">
                    </button>
            </div>
        </div>
    </div>
</template>

<style lang="">

</style>
