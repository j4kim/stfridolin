<script setup>
import Layout from "@/components/Layout.vue";
import StripePayment from "@/components/StripePayment.vue";
import { usePaymentStore } from "@/stores/payment";
import { useRoute } from "vue-router";

const paymentStore = usePaymentStore();
const route = useRoute();

if (paymentStore.payment?.id !== route.params.id) {
    paymentStore.fetchPayment(route.params.id);
}
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">Paiement</h2>
        <Suspense
            v-if="
                paymentStore.payment?.stripe_data.status ===
                'requires_payment_method'
            "
        >
            <StripePayment :intent="paymentStore.payment.stripe_data" />
        </Suspense>
    </Layout>
</template>
