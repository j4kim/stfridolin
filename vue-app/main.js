import "./css/app.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import { importFrames } from "./boxing/utils";
import App from "./App.vue";
import router from "./router";
import "./broadcasting";

const app = createApp(App);

app.use(createPinia());
app.use(router);

await importFrames();

app.mount("#app");
