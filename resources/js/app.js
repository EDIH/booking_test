import "./bootstrap";
import router from "./router";
import {
    ref,
    createApp,
    watch
} from "vue";
import axios from "axios";
import ElementPlus from "element-plus";
import VForm3 from "vform3-builds";

import 'element-plus/dist/index.css'  //引入element-plus样式
import 'vform3-builds/dist/designer.style.css'  //引入VForm3样式

import App from "./App.vue";
// import state from "./App.vue";

createApp(App)
    .use(router)
    .use(ElementPlus)
    .use(VForm3)
    .mount("#app");

window.axios = axios

const response = ref();

const getRooms = async () => {
    try {
        response.value = await axios.get("/api/search");
    } catch (error) {
        // Do something with the error
        console.log(error);
    }
};

// watch(state,
//     getRooms,
//     { immediate: true })
