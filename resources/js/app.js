import "./bootstrap";
import router from "./router";
import { createApp } from "vue";
import axios from "axios";
import { ref } from "vue";

import App from "./App.vue";

createApp(App)
    .use(router)
    .mount("#app");



const response = ref();

const getValue = async () => {
    try {
        response.value = await axios.get("/api/test");
    } catch (error) {
        // Do something with the error
        console.log(error);
    }
};
