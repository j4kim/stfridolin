<script setup>
import Layout from "@/components/Layout.vue";
import Button from "@/components/ui/button/Button.vue";
import { usePaymentStore } from "@/stores/payment";
import { CircleStar } from "lucide-vue-next";
import { useRouter } from "vue-router";

const paymentStore = usePaymentStore();
const router = useRouter();

async function createPayment(offer) {
    const payment = await paymentStore.createPayment(offer);
    router.push({ name: "payment", params: { id: payment.id } });
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
                @click="() => createPayment(offer)"
            >
                <CircleStar />
                {{ offer.tokens }} jetons - {{ offer.chf }} CHF
            </Button>
        </div>
    </Layout>
</template>
