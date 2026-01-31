<script setup>
import { loadStripe } from "@stripe/stripe-js";
import { onMounted, useTemplateRef } from "vue";

const props = defineProps({
    intent: Object,
});

const stripe = await loadStripe(import.meta.env.VITE_STRIPE_PK);

const appearance = {
    theme: "night",
    labels: "floating",
    inputs: "condensed",
};

const elements = stripe.elements({
    clientSecret: props.intent.client_secret,
    appearance: appearance,
});

const paymentContainer = useTemplateRef("paymentContainer");

onMounted(() => {
    const options = {
        layout: {
            type: "accordion",
            radios: true,
        },
    };
    const paymentElement = elements.create("payment", options);
    paymentElement.mount(paymentContainer.value);
});
</script>

<template>
    <div class="flex flex-col gap-2">
        <div>Achat de {{ intent.metadata.tokens }} jetons</div>
        <div class="text-xl">
            Total: <span class="font-bold">{{ intent.metadata.chf }} CHF</span>
        </div>
        <hr />
        <div ref="paymentContainer"></div>
    </div>
</template>
