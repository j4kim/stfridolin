<script setup>
import Layout from "@/components/Layout.vue";
import { Button } from "@/components/ui/button";
import { ArrowLeft, Home } from "lucide-vue-next";
import PaymentFeedback from "@/components/PaymentFeedback.vue";
import { AlertDescription } from "@/components/ui/alert";
import { usePaymentStore } from "@/stores/payment";

const paymentStore = usePaymentStore();
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">Statut du paiement</h2>
        <div class="flex flex-col justify-center gap-4 px-4">
            <PaymentFeedback>
                <template #requires_payment_method_error>
                    <AlertDescription>
                        Vous pouvez réessayer avec un autre moyen de paiement.
                        Ou alors aller au kiosque pour payer en cash.
                        <RouterLink
                            class="mt-2 w-full"
                            :to="{ name: 'buy-tokens' }"
                            v-if="paymentStore.payment"
                        >
                            <Button class="w-full">
                                <ArrowLeft />
                                Retour à la page d'achat
                            </Button>
                        </RouterLink>
                    </AlertDescription>
                </template>
            </PaymentFeedback>
            <RouterLink :to="{ name: 'home' }">
                <Button class="w-full" variant="outline">
                    <Home />
                    Retour à l'accueil
                </Button>
            </RouterLink>
        </div>
    </Layout>
</template>
