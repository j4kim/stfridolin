import { createRouter, createWebHistory } from "vue-router";
import { useMainStore } from "@/stores/main";
import { redirectToLogin } from "@/api";
import { useGuestStore } from "@/stores/guest";

const routes = [
    // Routes with no auth requested
    {
        path: "/",
        name: "home",
        component: () => import("@/views/Home.vue"),
    },
    {
        path: "/guest/auth",
        name: "guest-auth-form",
        component: () => import("@/views/GuestAuthForm.vue"),
    },
    {
        path: "/guest/:key",
        name: "guest-page",
        component: () => import("@/views/GuestPage.vue"),
    },
    {
        path: "/thunasse",
        name: "registration-payment",
        component: () => import("@/views/RegistrationPayment.vue"),
    },
    {
        path: "/thunasse/:id/status",
        name: "registration-payment-status",
        component: () => import("@/views/RegistrationPaymentStatus.vue"),
    },
    // Routes requiring guest auth
    {
        path: "/buy-tokens",
        name: "buy-tokens",
        component: () => import("@/views/BuyTokens.vue"),
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/payment/:id/status",
        name: "payment-status",
        component: () => import("@/views/PaymentStatus.vue"),
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/vote",
        name: "vote",
        component: () => import("@/views/Vote.vue"),
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/queue",
        name: "queue",
        component: () => import("@/views/Queue.vue"),
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/add-to-queue",
        name: "add-to-queue",
        component: () => import("@/views/AddToQueue.vue"),
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/marble-race",
        name: "marble-race",
        component: () => import("@/views/Tbi.vue"),
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/olympics",
        name: "olympics",
        component: () => import("@/views/Tbi.vue"),
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/joes-weight",
        name: "joes-weight",
        component: () => import("@/views/Tbi.vue"),
        meta: {
            requireGuest: true,
        },
    },
    {
        path: "/voucher/:id",
        name: "voucher",
        component: () => import("@/views/Voucher.vue"),
        meta: {
            requireGuest: true,
        },
    },
    // Routes requiring real auth
    {
        path: "/spotify",
        name: "spotify",
        component: () => import("@/views/Spotify.vue"),
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "/boxing",
        name: "boxing",
        component: () => import("@/views/Boxing.vue"),
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "/guest-cards",
        name: "guest-cards",
        component: () => import("@/views/GuestCards.vue"),
        meta: {
            requireAuth: true,
        },
    },
    {
        path: "/voucher-cards",
        name: "voucher-cards",
        component: () => import("@/views/VoucherCards.vue"),
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
