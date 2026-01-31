<script setup>
import { api } from "@/api";
import Layout from "@/components/Layout.vue";
import StripePayment from "@/components/StripePayment.vue";
import Button from "@/components/ui/button/Button.vue";
import { CircleStar } from "lucide-vue-next";
import { ref } from "vue";

const intent = ref(null);

async function createPaymentIntent(offer) {
    intent.value = await api("payments.create-intent").data(offer).post();
}
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">Acheter des jetons</h2>
        <div class="flex flex-col gap-4 px-4">
            <Button
                v-for="offer in [
                    { tokens: 40, chf: 10 },
                    { tokens: 100, chf: 20 },
                ]"
                @click="() => createPaymentIntent(offer)"
            >
                <CircleStar />
                {{ offer.tokens }} jetons - {{ offer.chf }} CHF
            </Button>
            <Suspense v-if="intent">
                <StripePayment :intent />
            </Suspense>
        </div>
    </Layout>
</template>
