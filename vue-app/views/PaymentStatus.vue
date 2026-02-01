<script setup>
import Layout from "@/components/Layout.vue";
import { usePaymentStore } from "@/stores/payment";
import { useRoute } from "vue-router";

const paymentStore = usePaymentStore();
const route = useRoute();

paymentStore.fetchPayment(route.params.id);
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">Statut du paiement</h2>
        <pre>
            {{ JSON.stringify(paymentStore.payment, null, 4) }}
        </pre>
    </Layout>
</template>
