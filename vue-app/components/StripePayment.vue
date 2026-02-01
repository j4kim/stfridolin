<script setup>
import { loadStripe } from "@stripe/stripe-js";
import { onMounted, ref, useTemplateRef } from "vue";
import { Button } from "./ui/button";
import { Alert, AlertDescription, AlertTitle } from "./ui/alert";
import { TriangleAlert } from "lucide-vue-next";
import { toast } from "vue-sonner";
import Spinner from "./ui/spinner/Spinner.vue";
import { useRouter } from "vue-router";

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
            defaultCollapsed: false,
        },
    };
    const paymentElement = elements.create("payment", options);
    paymentElement.mount(paymentContainer.value);
});

const router = useRouter();

const loading = ref(false);

async function submit() {
    loading.value = true;
    const redirectRoute = router.resolve({ name: "payment-status" });
    const return_url = location.origin + redirectRoute.href;
    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: { return_url },
        redirect: "if_required",
    });
    loading.value = false;
    if (error) {
        toast.error("Y a un souci", {
            description: error.message,
        });
    } else {
        router.push(redirectRoute);
    }
}
</script>

<template>
    <form class="mb-8 flex flex-col gap-2 px-4" @submit.prevent="submit">
        <div>Achat de {{ intent.metadata.tokens }} jetons</div>
        <div class="text-xl">
            Total:
            <span class="font-bold">{{ intent.metadata.amount }} CHF</span>
        </div>
        <hr />
        <div ref="paymentContainer"></div>
        <hr />
        <Alert>
            <TriangleAlert />
            <AlertTitle>Attention</AlertTitle>
            <AlertDescription>
                Les jetons ne sont pas remboursables. Merci pour votre soutien,
                amusez-vous bien !
            </AlertDescription>
        </Alert>
        <Button type="submit" :disabled="loading">
            <Spinner v-if="loading" />
            Continuer
        </Button>
    </form>
</template>
