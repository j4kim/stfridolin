import "@/css/app.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { importFrames } from "@/boxing/utils";
import App from "@/App.vue";
import router from "@/router";
import "@/broadcasting";
import { useClockStore } from "./stores/clock";
import { useMainStore } from "./stores/main";

const app = createApp(App);

app.use(createPinia());
app.use(router);

if (useMainStore().user) {
    useClockStore().startClock();
    await importFrames();
}

app.mount("#app");
