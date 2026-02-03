<script setup>
import Layout from "@/components/Layout.vue";
import NumberCard from "@/components/NumberCard.vue";
import { Button } from "@/components/ui/button";
import { useGuestStore } from "@/stores/guest";
import { CircleStar, Gift } from "lucide-vue-next";
import { useRoute } from "vue-router";

const route = useRoute();

const guestStore = useGuestStore();

guestStore.fetchGuest(route.params.key);
</script>

<template>
    <Layout v-if="guestStore.guest.id">
        <div>
            <h1 class="mt-8 text-center text-4xl">
                {{ guestStore.guest.name }}
            </h1>
            <h2
                class="mt-2 mb-8 text-center font-mono text-2xl tracking-widest opacity-50"
            >
                {{ guestStore.guest.key }}
            </h2>
            <div class="flex justify-evenly gap-4 px-4">
                <NumberCard
                    header="Jetons"
                    :value="guestStore.guest.tokens"
                    :icon="CircleStar"
                />
                <NumberCard
                    header="Points"
                    :value="guestStore.guest.points"
                    :icon="Gift"
                />
            </div>
            <div class="p-4">
                <RouterLink :to="{ name: 'buy-tokens' }">
                    <Button class="w-full" size="lg">
                        <CircleStar />
                        Acheter des jetons
                    </Button>
                </RouterLink>
            </div>
        </div>
    </Layout>
</template>
