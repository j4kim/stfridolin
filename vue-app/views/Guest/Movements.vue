<script setup>
import Layout from "@/components/Layout.vue";
import { useGuestStore } from "@/stores/guest";

const guestStore = useGuestStore();
</script>

<template>
    <Layout v-if="guestStore.guest.id">
        <h2 class="my-2 px-4 font-bold">Historique</h2>
    </Layout>
</template>
