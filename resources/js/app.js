import './bootstrap';
import { createApp } from 'vue';
import vueComponent from './Components/vueComponent.vue';
import modalComponent from './Components/modalComponent.vue';

function asd(){
    console.log("ay habl")
}
const app = createApp({});
app.component("vue-component", vueComponent);
app.component("modal-component",modalComponent);
app.mount("#app");

