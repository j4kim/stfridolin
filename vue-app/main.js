import "@/css/app.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { importFrames } from "@/boxing/utils";
import App from "@/App.vue";
import router from "@/router";
import "@/broadcasting";
import { useClientStore } from "./stores/client";

const app = createApp(App);

app.use(createPinia());
app.use(router);

useClientStore().getMasterClientId();

await importFrames();

app.mount("#app");
