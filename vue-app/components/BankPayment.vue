<script setup>
import { Button } from "@/components/ui/button";
import { usePaymentStore } from "@/stores/payment";
import { HandMetal } from "lucide-vue-next";
import { Alert, AlertDescription, AlertTitle } from "./ui/alert";

const paymentStore = usePaymentStore();
</script>

<template>
    <div class="mb-8 flex flex-col gap-3">
        <div class="mb-4 space-y-4">
            <p>Coordonnées bancaire:</p>
            <p>
                CH12 0076 6000 1036 5988 5<br />
                Association Salut Zamme<br />
                Rue de la Côte 27<br />
                2000 Neuchâtel<br />
            </p>
            <p>
                Montant: <strong>CHF {{ paymentStore.payment.amount }}</strong>
            </p>
            <p>
                <a
                    class="link"
                    href="/facture-inscription-st-fridolin.pdf"
                    target="_blank"
                    >QR facture</a
                >
            </p>
        </div>

        <Alert>
            <HandMetal />
            <AlertTitle>Merci !</AlertTitle>
            <AlertDescription>
                <p>
                    Ton inscription sera confirmée quand nous aurons reçu ton
                    paiement.
                </p>
            </AlertDescription>
        </Alert>

        <Button class="w-full" variant="ghost" @click="paymentStore.cancel()">
            Retour
        </Button>
    </div>
</template>
