import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import { useMainStore } from "../stores/main";
import { redirectToLogin } from "../api";
import Spotify from "../views/Spotify.vue";
import Boxers from "../views/Boxers.vue";

const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
    },
    {
        path: "/spotify",
        name: "spotify",
        component: Spotify,
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "/boxers",
        name: "boxers",
        component: Boxers,
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
});

router.beforeEach((to) => {
    if (to.meta?.requireAuth && !useMainStore().user) {
        redirectToLogin(to.href);
        return false;
    }
});

export default router;
