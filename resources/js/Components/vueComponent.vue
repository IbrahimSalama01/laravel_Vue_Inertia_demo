<script setup>
import {ref, defineProps, reactive} from 'vue';
import modalComponent from './modalComponent.vue';
const props = defineProps(["postid"])
let counter = ref(0);
//import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

const open = ref(false) // Modal is closed by default
let post = reactive({});
const openModal= async(id)=>{
    let response = await axios.get(`/api/post/${props.postid}`);
    post = response.data.data;
    //console.log(post);
    open.value =true;
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
    <div>
        <button class="px-3 py-1 bg-amber-500 hover:bg-amber-900 rounded-sm text-white font-medium"
        @click="openModal"
        >Display info</button>
        <TransitionRoot as="template" :show="open">
        <Dialog class="relative z-10" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto ">
                <div class="flex min-h-full items-end justify-center min-w-5/6 p-4 text-center sm:items-center sm:p-0 ">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative py-10 transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all
                        sm:my-8 sm:w-full sm:max-w-4xl">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start border-b-2 border-gray-200 py-5">

                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <DialogTitle  class="text-lg font-bold text-gray-900">Post {{post.id}}</DialogTitle>
                                        <DialogTitle as="h3" class="text-lg font-bold text-gray-900">Title: {{post.title}}</DialogTitle>
                                        <div class="mt-2 ">
                                            <p class="text-sm text-gray-500">
                                                {{post.description}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="sm:flex sm:items-start  py-5">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <DialogTitle as="h3" class="text-md font-bold text-gray-900 mb-2">Posted_By: {{post.user_name}}</DialogTitle>
                                        <DialogTitle as="h3" class="text-sm font-semibold text-gray-900">created_at: {{formatTime(post.created_at)}}</DialogTitle>

                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-gray-400 px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                @click="open = false">Close</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    </div>
</template>

<style lang="">

</style>
