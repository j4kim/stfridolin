<script setup>
import Layout from "@/components/Layout.vue";
import StripePayment from "@/components/StripePayment.vue";
import TokenPackages from "@/components/TokenPackages.vue";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { useArticlesStore } from "@/stores/articles";
import { usePaymentStore } from "@/stores/payment";
import { computed, ref } from "vue";

const paymentStore = usePaymentStore();

paymentStore.payment = null;

const articlesStore = useArticlesStore();

const stdPackages = computed(() =>
    articlesStore.tokenPackages.filter((p) => p.std_price === p.price),
);

const discountPackages = computed(() =>
    articlesStore.tokenPackages
        .filter((p) => p.std_price !== p.price)
        .map((p) => ({
            ...p,
            discount: (100 * (p.std_price - p.price)) / p.std_price,
        })),
);

const loading = ref(false);

function createPayment(article) {
    loading.value = true;
    paymentStore
        .createPayment(article, { purpose: "buy-tokens" })
        .finally(() => (loading.value = false));
}
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">Acheter des jetons</h2>
        <Spinner v-if="loading" class="mx-auto size-8" />
        <StripePayment v-else-if="paymentStore.payment" class="px-4" />
        <div v-else>
            <TokenPackages
                :articles="stdPackages"
                @select="(article) => createPayment(article)"
            />
            <h2 class="mt-6 mb-2 px-4 font-medium italic">
                Offres spéciales de la Saint-Fridolin :
            </h2>
            <TokenPackages
                :articles="discountPackages"
                @select="(article) => createPayment(article)"
            />
        </div>
    </Layout>
</template>
