<script setup>
import Layout from "@/components/Layout.vue";
import NumberCard from "@/components/NumberCard.vue";
import { Button } from "@/components/ui/button";
import { useGuestStore } from "@/stores/guest";
import { CircleStar, Gift, Home, Power } from "lucide-vue-next";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const guestStore = useGuestStore();

guestStore.fetchGuest(route.params.key);

function logOut() {
    guestStore.guest = {};
    router.push({ name: "guest-auth-form" });
}
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
            <div class="flex flex-col gap-4 p-4">
                <RouterLink :to="{ name: 'buy-tokens' }">
                    <Button class="w-full" size="lg">
                        <CircleStar />
                        Acheter des jetons
                    </Button>
                </RouterLink>
                <RouterLink :to="{ name: 'home' }">
                    <Button class="w-full" size="lg" variant="outline">
                        <Home />
                        Accueil
                    </Button>
                </RouterLink>
                <Button size="lg" variant="outline" @click="logOut">
                    <Power />
                    Se déconnecter
                </Button>
            </div>
        </div>
    </Layout>
</template>
