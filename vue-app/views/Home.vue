<script setup>
import { useGuestStore } from "@/stores/guest";
import { defineAsyncComponent } from "vue";
import FullPageLoading from "./FullPageLoading.vue";

const guestStore = useGuestStore();

const HomeAuthenticated = defineAsyncComponent({
    loader: () => import("./HomeAuthenticated.vue"),
    loadingComponent: FullPageLoading,
    delay: 100,
});
const HomeUnauthenticated = defineAsyncComponent({
    loader: () => import("./HomeUnauthenticated.vue"),
    loadingComponent: FullPageLoading,
    delay: 100,
});
</script>

<template>
    <HomeAuthenticated v-if="guestStore.guest.id" />
    <HomeUnauthenticated v-else />
</template>
