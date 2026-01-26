import { createRouter, createWebHistory } from "vue-router";
import { useMainStore } from "@/stores/main";
import { redirectToLogin } from "@/api";
import Spotify from "@/views/Spotify.vue";
import Boxing from "@/views/Boxing.vue";
import Vote from "@/views/Vote.vue";
import AddToQueue from "@/views/AddToQueue.vue";
import Queue from "@/views/Queue.vue";
import { useGuestStore } from "@/stores/guest";
import GuestAuthForm from "@/views/GuestAuthForm.vue";

const routes = [
    {
        path: "/guest/auth",
        name: "guest-auth-form",
        component: GuestAuthForm,
    },
    {
        path: "/",
        name: "vote",
        component: Vote,
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/queue",
        name: "queue",
        component: Queue,
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/add-to-queue",
        name: "add-to-queue",
        component: AddToQueue,
        meta: {
            requireGuest: true,
        },
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
        meta: {
            requireAuth: true,
        },
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
    if (to.meta?.requireGuest && !useGuestStore().guest) {
        return { name: "guest-auth-form" };
    }
});

export default router;
