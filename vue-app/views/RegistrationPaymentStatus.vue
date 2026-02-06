<script setup>
import { Button } from "@/components/ui/button";
import { usePaymentStore } from "@/stores/payment";
import titleSvg from "@/title.svg";
import PaymentFeedback from "./PaymentFeedback.vue";
import AlertDescription from "@/components/ui/alert/AlertDescription.vue";
import { ArrowLeft } from "lucide-vue-next";

const paymentStore = usePaymentStore();
</script>

<template>
    <div class="mx-auto max-w-xl p-8">
        <img class="mx-auto max-w-xl p-12" :src="titleSvg" />

        <h2 class="my-4 text-xl font-bold">Statut du paiement</h2>

        <div class="flex flex-col justify-center gap-4">
            <PaymentFeedback>
                <template #requires_payment_method_error>
                    <AlertDescription>
                        Vous pouvez réessayer avec un autre moyen de paiement.
                        Ou alors faire un virement bancaire.
                        <RouterLink
                            class="mt-2 w-full"
                            :to="{ name: 'registration-payment' }"
                            v-if="paymentStore.payment"
                        >
                            <Button class="w-full">
                                <ArrowLeft />
                                Retour à la page de paiement
                            </Button>
                        </RouterLink>
                    </AlertDescription>
                </template>
            </PaymentFeedback>
        </div>
    </div>
</template>
