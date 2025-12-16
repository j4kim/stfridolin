import { createRouter, createWebHistory } from "vue-router";
import { useMainStore } from "../stores/main";
import { redirectToLogin } from "../api";
import Spotify from "../views/Spotify.vue";
import Boxing from "../views/Boxing.vue";
import Vote from "../views/Vote.vue";

const routes = [
    {
        path: "/",
        name: "vote",
        component: Vote,
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
        path: "/boxing",
        name: "boxing",
        component: Boxing,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to) => {
    if (to.meta?.requireAuth && !useMainStore().user) {
        redirectToLogin(to.href);
        return false;
    }
});

export default router;
