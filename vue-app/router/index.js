import { createRouter, createWebHistory } from "vue-router";
import { redirectToLogin } from "@/tools";
import { useMainStore } from "@/stores/main";

const routes = [
    // Routes with no auth requested
    {
        path: "/",
        name: "home",
        component: () => import("@/views/Home.vue"),
    },
    {
        path: "/page/:page",
        name: "page",
        component: () => import("@/views/PublicPage.vue"),
    },
    {
        path: "/auth",
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
    {
        path: "/spend/:currency",
        name: "spend",
        component: () => import("@/views/Spend.vue"),
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
    {
        path: "/qr-scan",
        name: "qr-scan",
        component: () => import("@/views/QrScan.vue"),
        meta: {
            requireAuth: true,
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        // always scroll to top
        return { top: 0 };
    },
});

router.beforeEach(async (to) => {
    const mainStore = useMainStore();
    mainStore.navigating = true;
    if (to.meta?.requireAuth && !mainStore.user) {
        redirectToLogin(to.href);
        return false;
    }
    const { useGuestStore } = await import("@/stores/guest");
    if (to.meta?.requireGuest && !useGuestStore().guest.id) {
        return { name: "guest-auth-form" };
    }
});

router.afterEach(() => {
    useMainStore().navigating = false;
});

router.onError(() => {
    useMainStore().navigating = false;
});

export default router;
