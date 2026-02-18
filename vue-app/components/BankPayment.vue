<script setup>
import { Button } from "@/components/ui/button";
import { usePaymentStore } from "@/stores/payment";

const paymentStore = usePaymentStore();
</script>

<template>
    <div>
        Payment par virement bancaire
        <Button class="w-full" variant="ghost" @click="paymentStore.cancel()">
            Retour
        </Button>
    </div>
</template>
