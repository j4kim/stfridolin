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
            <h1 class="p-8 text-center text-4xl">
                {{ guestStore.guest.name }}
            </h1>
            <div class="flex justify-evenly">
                <Card class="w-1/3">
                    <CardHeader>Jetons</CardHeader>
                    <CardContent class="text-4xl font-black">
                        {{ guestStore.guest.tokens }}
                    </CardContent>
                </Card>
                <Card class="w-1/3">
                    <CardHeader>Points</CardHeader>
                    <CardContent class="text-4xl font-black">
                        {{ guestStore.guest.points }}
                    </CardContent>
                </Card>
            </div>
        </div>
    </Layout>
</template>
