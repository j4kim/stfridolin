<script setup>
import Layout from "@/components/Layout.vue";
import StripePayment from "@/components/StripePayment.vue";
import Button from "@/components/ui/button/Button.vue";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { useArticlesStore } from "@/stores/articles";
import { usePaymentStore } from "@/stores/payment";
import { CircleStar } from "lucide-vue-next";
import { ref } from "vue";

const paymentStore = usePaymentStore();

const articlesStore = useArticlesStore();

paymentStore.payment = null;

const loading = ref(false);

function createPayment(article) {
    loading.value = true;
    paymentStore
        .createPayment({
            amount: article.price,
            purpose: "buy-tokens",
            tokens: article.meta.tokens,
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
                v-for="article in articlesStore.tokenPackages"
                @click="() => createPayment(article)"
            >
                <CircleStar />
                {{ article.description }} - {{ article.price }} CHF
            </Button>
        </div>
    </Layout>
</template>
