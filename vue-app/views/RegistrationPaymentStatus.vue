<script setup>
import { Button } from "@/components/ui/button";
import { usePaymentStore } from "@/stores/payment";
import titleSvg from "@/title.svg";
import PaymentFeedback from "./PaymentFeedback.vue";
import { ArrowLeft } from "lucide-vue-next";
import { AlertTitle, AlertDescription } from "@/components/ui/alert";

const paymentStore = usePaymentStore();
</script>

<template>
    <div class="mx-auto max-w-xl p-8">
        <img class="mx-auto max-w-xl p-12" :src="titleSvg" />

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
                <template #success_alert_content>
                    <AlertTitle>Paiement réussi ! 🎉</AlertTitle>
                    <AlertDescription>
                        Merci beaucoup ! On se retrouve le 6 mars à 18h au Bik !
                    </AlertDescription>
                </template>
            </PaymentFeedback>
        </div>
    </div>
</template>
