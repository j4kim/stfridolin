import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import { useMainStore } from "../stores/main";
import { redirectToLogin } from "../api";

const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
});

router.beforeEach((to) => {
    if (to.meta?.requireAuth && !useMainStore().user) {
        redirectToLogin("/" + to.href);
        return false;
    }
});

export default router;
