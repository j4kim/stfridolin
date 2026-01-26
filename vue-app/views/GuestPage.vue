<script setup>
import Layout from "@/components/Layout.vue";
import { useGuestStore } from "@/stores/guest";
import { useRoute } from "vue-router";

const route = useRoute();

const guestStore = useGuestStore();

guestStore.fetchGuest(route.params.key);
</script>

<template>
    <Layout simple> {{ guestStore.guest.name }} </Layout>
</template>
