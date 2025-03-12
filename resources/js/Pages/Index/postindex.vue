<script setup>
import navbar from './navbar.vue';
import postbody from './body.vue';
import { defineProps } from 'vue';
const props = defineProps(["posts","users"]);
//console.log(props);
const asd ="asd"
</script>
<template lang="">
    <div class="flex flex-col items-center w-full h-screen">
        <navbar/>
        <postbody :users="props.users" :posts="props.posts" />
    </div>
</template>

<style lang="">

</style>
