<script setup>
import { Button } from "@/components/ui/button";
import { usePaymentStore } from "@/stores/payment";
import { HandMetal } from "lucide-vue-next";
import { Alert, AlertDescription, AlertTitle } from "./ui/alert";

const paymentStore = usePaymentStore();
</script>

<template>
    <div class="mb-8 flex flex-col gap-3">
        <Alert>
            <HandMetal />
            <AlertTitle>Merci !</AlertTitle>
            <AlertDescription>
                <p>
                    Ton inscription sera confirmée quand nous aurons reçu ton
                    paiement.
                </p>
                <p>
                    La page de paiement Twint ne s'est pas ouverte ?
                    <a
                        :href="paymentStore.twintPaymentLink"
                        target="_blank"
                        class="link"
                        >Clique ici</a
                    >.
                </p>
            </AlertDescription>
        </Alert>

        <Button class="w-full" variant="ghost" @click="paymentStore.cancel()">
            Retour
        </Button>
    </div>
</template>
