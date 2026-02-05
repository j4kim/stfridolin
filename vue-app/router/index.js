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
import GuestPage from "@/views/GuestPage.vue";
import Home from "@/views/Home.vue";
import BuyTokens from "@/views/BuyTokens.vue";
import PaymentStatus from "@/views/PaymentStatus.vue";
import RegistrationPayment from "@/views/RegistrationPayment.vue";
import RegistrationPaymentStatus from "@/views/RegistrationPaymentStatus.vue";
import GuestCards from "@/views/GuestCards.vue";
import Tbi from "@/views/Tbi.vue";

const routes = [
    {
        path: "/guest/auth",
        name: "guest-auth-form",
        component: GuestAuthForm,
    },
    {
        path: "/guest/:key",
        name: "guest-page",
        component: GuestPage,
    },
    {
        path: "/auth/:key",
        redirect: { name: "guest-page" },
        component: GuestPage,
    },
    {
        path: "/registration-payment",
        name: "registration-payment",
        component: RegistrationPayment,
    },
    {
        path: "/registration-payment/:id/status",
        name: "registration-payment-status",
        component: RegistrationPaymentStatus,
    },
    {
        path: "/",
        name: "home",
        component: Home,
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/buy-tokens",
        name: "buy-tokens",
        component: BuyTokens,
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/payment/:id/status",
        name: "payment-status",
        component: PaymentStatus,
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/vote",
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
        path: "/marble-race",
        name: "marble-race",
        component: Tbi,
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/olympics",
        name: "olympics",
        component: Tbi,
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/joes-weight",
        name: "joes-weight",
        component: Tbi,
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
    {
        path: "/guest-cards",
        name: "guest-cards",
        component: GuestCards,
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
    if (to.meta?.requireGuest && !useGuestStore().guest.id) {
        return { name: "guest-auth-form" };
    }
});

export default router;
