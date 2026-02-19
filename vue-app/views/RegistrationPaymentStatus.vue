<script setup>
import { Button } from "@/components/ui/button";
import { usePaymentStore } from "@/stores/payment";
import PaymentFeedback from "./PaymentFeedback.vue";
import { ArrowLeft } from "lucide-vue-next";
import { AlertTitle, AlertDescription } from "@/components/ui/alert";
import PublicLayout from "@/components/PublicLayout.vue";

const paymentStore = usePaymentStore();
</script>

<template>
    <PublicLayout>
        <div class="flex flex-col justify-center gap-4">
            <PaymentFeedback>
                <template #requires_payment_method_error>
                    <AlertDescription>
                        <p>
                            Vous pouvez réessayer avec un autre moyen de
                            paiement. Ou alors faire
                            <a
                                class="link"
                                href="/facture-inscription-st-fridolin.pdf"
                                target="_blank"
                                >un virement bancaire</a
                            >.
                        </p>
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
    </PublicLayout>
</template>
