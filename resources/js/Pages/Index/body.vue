<script setup >
import { defineProps, ref, reactive, computed } from 'vue';
import { router, usePoll } from '@inertiajs/vue3';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/Components/ui/alert-dialog'
import { Button } from '@/components/ui/button'
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert'
import { AlertCircle } from 'lucide-vue-next'
import { usePage } from "@inertiajs/vue3";


let selectedPost = reactive({});
let errors = ref(null);
let selectedUser = ref(null)
let createDialogOpen=ref(false);
let updateDialogOpen=ref(false);
let file = null;
const page = usePage();
const regUser = computed(() => page.props.auth.user);
const props = defineProps(["posts","users"]);
//console.log(props)
const fetchPage = (url) =>{
    if (url) {
        router.get(url);
    }
}
const createclicked = ()=>{
    selectedPost= {};
}

const changeImage = (event)=>{
    file = event.target.files[0];
}
const createConfirmed = ()=>{
        selectedPost.user_id = selectedUser.value;
        if(!file){
            console.log("add photo");
            createDialogOpen.value = true;
        }
        let formData = new FormData();
        formData.append("photo", file);
        formData.append("user_id", page.props.auth.user.id);
        formData.append("title",selectedPost.title);
        formData.append("description",selectedPost.description);

        router.post(`/posts`,formData,{
        forceFormData: true,
        preserveState: true,
        onSuccess: () => {
            selectedPost= {};
            file = null;
            clearError();
        },
        onError:(errorMessagess)=>{
            console.log(errorMessagess);
            errors.value = errorMessagess;
            createDialogOpen.value = true;
        }
    });
}

const clearError = (index)=>{
    //console.log(index);
    if(!index){
        errors.value={};
    }
    delete errors.value[index];
}
const viewClicked = (post)=>{
    Object.assign(selectedPost, post);
    selectedUser.value = post.user_id
}
const deleteClicked = (post)=>{
    Object.assign(selectedPost, post);
    selectedUser.value = post.user_id
}
const updateClicked = (post)=>{
    Object.assign(selectedPost, post);

    selectedUser.value = post.user_id
}

const deleteConfirmed = ()=>{
    router.delete(`/post/${selectedPost.id}`,{
        preserveState: true,
        onSuccess: () => {
            selectedPost = {};
        }
    });
}
    const updateConfirmed = ()=>{
        selectedPost.user_id = selectedUser.value;
        let formData = new FormData();
        //formData.append("photo", file);
        formData.append("user_id", page.props.auth.user.id);
        formData.append("title",selectedPost.title);
        formData.append("description",selectedPost.description);
        if (file) {
            formData.append("photo", file);
        }
        router.post(`/post/${selectedPost.id}`,formData,{
            forceFormData: true,
            preserveState: true,
        onSuccess: () => {
            selectedPost = {};
            file = null;
            clearError();
        },
        onError(errorMessagess){
            console.log(errorMessagess);
            errors.value = errorMessagess;
            updateDialogOpen.value = true;
        }
    });
}


const formatTime = (date) => {
    if (!date) return 'N/A';
    return new Intl.DateTimeFormat("en-US", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: true,
    }).format(new Date(date));
};
</script>
<template lang="">
    <div class = "w-full px-4 h-11/12">
        <!-- <div v-if="errors"> -->
            <div v-for="(error, index) in errors" :key="index" class="mb-2 overflow-hidden text-white bg-red-400 rounded-xl">
                <Alert variant="destructive">
                    <AlertTitle>{{index}}</AlertTitle>
                    <div class="flex justify-between">
                    <AlertDescription>{{ error }}</AlertDescription>
                    <Button variant="outline" class="justify-end text-black" @click="clearError(index)">
                    Dismiss
                    </Button>
                </div>
                </Alert>
            </div>
        <!-- </div> -->

        <div class="flex flex-col gap-3 py-4">
            <div class="flex justify-center items-ceneter">
                <AlertDialog v-model:open="createDialogOpen">
                    <AlertDialogTrigger @click="createclicked" class="px-4 py-3 font-bold text-white bg-green-500 rounded-md hover:bg-green-700"> Create Post</AlertDialogTrigger>
                    <!-- <AlertDialogTrigger @click="viewClicked(post)" class="px-3 py-1 mx-2 text-sm text-white bg-blue-500 rounded-md hover:bg-blue-700"> update</AlertDialogTrigger> -->
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>
                                <div>
                                    <!-- Title Input -->
                                    <div class="mb-4">
                                        <label for="title" class="block mb-1 text-sm font-medium text-gray-700">Title</label>
                                        <input name="title" type="text" id="title"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            v-model="selectedPost.title">
                                    </div>
                                    <!-- Description Textarea -->
                                    <div class="mb-4">
                                        <label for="description"
                                            class="block mb-1 text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="description" id="description" rows="5" v-model="selectedPost.description"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" ></textarea>
                                    </div>

                                    <!-- Post Creator Select -->
                                    <div class="mb-6">
                                        <label for="creator" class="block mb-1 text-sm font-medium text-gray-700">Post Creator</label>
                                        <select name="post_creator" id="creator" v-model="regUser.id"  disabled
                                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <option  v-for="user in props.users" :key="user.id" :value="user.id"  >

                                                {{user.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-6 ">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                                        <input class="block w-full h-12 py-3 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                id="file_input" name="image" type="file"
                                                @change="changeImage">
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG or JPG (MAX. 800x400px).</p>
                                    </div>
                                </div>
                            </AlertDialogTitle>
                        </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel @click="clearError()">Cancel</AlertDialogCancel>
                        <AlertDialogAction @click="createConfirmed">Create</AlertDialogAction>
                    </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </div>
            <div class="flex flex-grow w-full">
                <table class="min-w-full text-center divide-gray-700 ">
                    <thead class="font-bold bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-gray-900 whitespace">#</th>
                            <th class="px-4 py-2 text-gray-900 whitespace">Title</th>
                            <th class="px-4 py-2 text-gray-900 whitespace">Slug</th>
                            <th class="px-4 py-2 text-gray-900 whitespace">Posted By</th>
                            <th class="px-4 py-2 text-gray-900 whitespace">Created At</th>
                            <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="post in props.posts.data" :key="post.id">
                            <td class="px-4 py-2 text-gray-700 whitespace" >{{post.id}}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace" >{{post.title}}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace" >{{post.slug}}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace" >{{post.user.name}}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace" >{{formatTime(post.created_at)}}</td>
                            <td class="px-4 py-2 text-gray-700 whitespace-nowrap" >
                                <!-- view -->
                                <AlertDialog>
                                    <AlertDialogTrigger @click="viewClicked(post)" class="px-3 py-1 mx-2 text-sm text-white bg-blue-400 rounded-md hover:bg-blue-500"> view</AlertDialogTrigger>
                                    <AlertDialogContent>
                                        <AlertDialogHeader>
                                            <AlertDialogTitle>
                                                <h3>Post: {{selectedPost.id}}</h3>
                                                <h3>Title:  {{selectedPost.title}}</h3>
                                        </AlertDialogTitle>
                                        <AlertDialogDescription>
                                            <div>
                                                <img :src="'photos/'+selectedPost.id" alt="" class="w-full mb-8">
                                                <p>{{selectedPost.description}}</p>
                                                <div class="py-4 mt-4 border-t-2 border-gray-400">
                                                <p class="text-lg font-bold " >Posted by: {{selectedPost.user.name}}</p>
                                                <p>Create at: {{formatTime(selectedPost.created_at)}}</p>
                                                </div>
                                            </div>
                                        </AlertDialogDescription>
                                    </AlertDialogHeader>
                                    <AlertDialogFooter>
                                        <!-- <AlertDialogCancel>Cancel</AlertDialogCancel> -->
                                        <AlertDialogAction>OK</AlertDialogAction>
                                    </AlertDialogFooter>
                                </AlertDialogContent>
                            </AlertDialog>
                            <!-- Edit -->
                            <AlertDialog v-model:open="updateDialogOpen" >
                                <AlertDialogTrigger @click="viewClicked(post)" :disabled="post.user.id != regUser.id"
                                class="px-3 py-1 mx-2 text-sm text-white bg-blue-700 rounded-md hover:bg-blue-900 disabled:bg-gray-500"> update</AlertDialogTrigger>
                                <AlertDialogContent>
                                    <AlertDialogHeader>
                                        <AlertDialogTitle>
                                            <div>
                                                <!-- Title Input -->
                                                <div class="mb-4">
                                                    <label for="title" class="block mb-1 text-sm font-medium text-gray-700">Title</label>
                                                    <input name="title" type="text" id="title"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                        v-model="selectedPost.title">
                                                </div>

                                                <!-- Description Textarea -->
                                                <div class="mb-4">
                                                    <label for="description"
                                                        class="block mb-1 text-sm font-medium text-gray-700">Description</label>
                                                    <textarea name="description" id="description" rows="5" v-model="selectedPost.description"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" ></textarea>
                                                </div>

                                                <!-- Post Creator Select -->
                                                <div class="mb-6">
                                                    <label for="creator" class="block mb-1 text-sm font-medium text-gray-700">Post Creator</label>
                                                    <select name="post_creator" id="creator" v-model="regUser.id"  disabled
                                                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                        <option  v-for="user in props.users" :key="user.id" :value="user.id"  >
                                                            {{user.name}}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="mb-6 ">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload new photo</label>
                                                    <input class="block w-full h-12 py-3 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                            id="file_input" name="image" type="file"
                                                            @change="changeImage">
                                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG or JPG (MAX. 800x400px).</p>
                                                </div>
                                            </div>
                                        </AlertDialogTitle>
                                    </AlertDialogHeader>
                                <AlertDialogFooter>
                                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                                    <AlertDialogAction @click="updateConfirmed(selectedPost)">Update</AlertDialogAction>
                                </AlertDialogFooter>
                                </AlertDialogContent>
                            </AlertDialog>

                            <!-- delete -->
                            <AlertDialog>
                                <AlertDialogTrigger @click="viewClicked(post)" :disabled="post.user.id != regUser.id"
                                class="px-3 py-1 mx-2 text-sm text-white bg-red-500 rounded-md hover:bg-red-800 disabled:bg-gray-500"> remove</AlertDialogTrigger>
                                <AlertDialogContent>
                                    <AlertDialogHeader>
                                        <AlertDialogTitle>
                                            Are you Sure you want delete {{selectedPost.id}} ?
                                    </AlertDialogTitle>
                                </AlertDialogHeader>
                                <AlertDialogFooter>
                                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                                    <AlertDialogAction  @click="deleteConfirmed(post)">confirm</AlertDialogAction>
                                </AlertDialogFooter>
                                </AlertDialogContent>
                            </AlertDialog>
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

                        :class="{'font-bold bg-blue-600 text-white': link.active}"
                        class="px-3 py-1 border rounded">
                    </button>
            </div>
        </div>



    </div>
</template>

<style lang="">

</style>
