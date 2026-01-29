<script setup>
import Layout from "@/components/Layout.vue";
import { Card, CardContent, CardHeader } from "@/components/ui/card";
import { useGuestStore } from "@/stores/guest";
import { useRoute } from "vue-router";

const route = useRoute();

const guestStore = useGuestStore();

guestStore.fetchGuest(route.params.key);
</script>

<template>
    <Layout simple>
        <div>
            <h1 class="mt-8 text-center text-4xl">
                {{ guestStore.guest.name }}
            </h1>
            <h2
                class="mt-2 mb-8 text-center font-mono text-2xl font-light tracking-widest opacity-50"
            >
                {{ guestStore.guest.key }}
            </h2>
            <div class="flex justify-evenly gap-4 px-4">
                <Card class="w-full">
                    <CardHeader>Jetons</CardHeader>
                    <CardContent class="text-3xl font-bold">
                        {{ guestStore.guest.tokens }}
                    </CardContent>
                </Card>
                <Card class="w-full">
                    <CardHeader>Points</CardHeader>
                    <CardContent class="text-3xl font-bold">
                        {{ guestStore.guest.points }}
                    </CardContent>
                </Card>
            </div>
        </div>
    </Layout>
</template>
