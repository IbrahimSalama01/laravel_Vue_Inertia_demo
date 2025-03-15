<script setup>
import { usePage } from '@inertiajs/vue3';
import logo from '../../Components/ApplicationLogo.vue'
import { computed } from 'vue';
let page = usePage();
let user = computed(()=>page.props.auth.user);
</script>
<template lang="">
    <div class="w-full ">
        <div class="flex justify-between gap-2 px-5 py-3 h-18 bg-amber-600">
            <div class="flex items-center gap-4 ">
                <logo class="w-14"/>
                <p class="font-serif text-2xl font-black text-center text-white" > ITI Blog </p>
            </div>
            <div class="flex flex-col items-center">
                <p class="font-serif text-lg font-semibold text-white " > {{user.name}} </p>
                <p class="font-serif text-sm text-white " > {{user.email}} </p>
            </div>
        </div>
    </div>
</template>

<style lang="">

</style>
