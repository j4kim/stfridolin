<script setup>
import { useGuestStore } from "@/stores/guest";
import { defineAsyncComponent } from "vue";

const guestStore = useGuestStore();

const HomeAuthenticated = defineAsyncComponent(
    () => import("./HomeAuthenticated.vue"),
);
const HomeUnauthenticated = defineAsyncComponent(
    () => import("./HomeUnauthenticated.vue"),
);
</script>

<template>
    <HomeAuthenticated v-if="guestStore.guest.id" />
    <HomeUnauthenticated v-else />
</template>
