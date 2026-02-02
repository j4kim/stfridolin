<script setup>
import Layout from "@/components/Layout.vue";
import StripePayment from "@/components/StripePayment.vue";
import Button from "@/components/ui/button/Button.vue";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { usePaymentStore } from "@/stores/payment";
import { CircleStar } from "lucide-vue-next";
import { ref } from "vue";

const paymentStore = usePaymentStore();

paymentStore.payment = null;

const loading = ref(false);

function createPayment(offer) {
    loading.value = true;
    paymentStore
        .createPayment({
            amount: offer.chf,
            purpose: "buy-tokens",
            tokens: offer.tokens,
        })
        .finally(() => (loading.value = false));
}
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">Acheter des jetons</h2>
        <Spinner v-if="loading" class="mx-auto size-8" />
        <StripePayment v-else-if="paymentStore.payment" />
        <div v-else class="flex flex-col gap-4 px-4">
            <Button
                v-for="offer in [
                    { tokens: 40, chf: 10 },
                    { tokens: 100, chf: 20 },
                ]"
                @click="() => createPayment(offer)"
            >
                <CircleStar />
                {{ offer.tokens }} jetons - {{ offer.chf }} CHF
            </Button>
        </div>
    </Layout>
</template>
