<script setup>
import { useGuestStore } from "@/stores/guest";
import HomeAuthenticated from "./HomeAuthenticated.vue";
import HomeUnauthenticated from "./HomeUnauthenticated.vue";

const guestStore = useGuestStore();
</script>

<template>
    <HomeAuthenticated v-if="guestStore.guest.id" />
    <HomeUnauthenticated v-else />
</template>
