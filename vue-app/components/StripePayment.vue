<script setup>
import { loadStripe } from "@stripe/stripe-js";
import { onMounted, ref, useTemplateRef } from "vue";
import { Button } from "./ui/button";
import { Alert, AlertDescription } from "./ui/alert";
import { TriangleAlert } from "lucide-vue-next";
import { route } from "../../vendor/tightenco/ziggy";

const props = defineProps({
    intent: Object,
});

const err = ref("");

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
            defaultCollapsed: false,
        },
    };
    const paymentElement = elements.create("payment", options);
    paymentElement.mount(paymentContainer.value);
});

async function submit() {
    err.value = "";
    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: {
            return_url: route("payments.stripe-callback"),
        },
    });
    err.value = error.message;
}
</script>

<template>
    <form class="mb-8 flex flex-col gap-2 px-4" @submit.prevent="submit">
        <div>Achat de {{ intent.metadata.tokens }} jetons</div>
        <div class="text-xl">
            Total: <span class="font-bold">{{ intent.metadata.chf }} CHF</span>
        </div>
        <hr />
        <div ref="paymentContainer"></div>
        <Alert class="mt-4" variant="destructive" v-if="err">
            <TriangleAlert />
            <AlertDescription>
                {{ err }}
            </AlertDescription>
        </Alert>
        <hr />
        <Button type="submit">Continuer</Button>
    </form>
</template>
