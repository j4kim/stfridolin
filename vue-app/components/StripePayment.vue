<script setup>
import { loadStripe } from "@stripe/stripe-js";
import { computed, onMounted, ref, useTemplateRef } from "vue";
import { Button } from "./ui/button";
import { Alert, AlertDescription, AlertTitle } from "./ui/alert";
import { TriangleAlert } from "lucide-vue-next";
import { toast } from "vue-sonner";
import Spinner from "./ui/spinner/Spinner.vue";
import { useRouter } from "vue-router";
import { usePaymentStore } from "@/stores/payment";

const paymentStore = usePaymentStore();

const router = useRouter();

const loading = ref(false);
const loadingStripe = ref(true);

let stripe = null;
let elements = null;

const paymentContainer = useTemplateRef("paymentContainer");

const intent = computed(() => paymentStore.payment.stripe_data);

onMounted(async () => {
    stripe = await loadStripe(import.meta.env.VITE_STRIPE_PK);

    const clientSecret = intent.value.client_secret;

    const appearance = {
        theme: "night",
        labels: "floating",
        inputs: "condensed",
    };

    elements = stripe.elements({ clientSecret, appearance });

    const options = {
        layout: {
            type: "accordion",
            radios: true,
            defaultCollapsed: false,
        },
    };

    const paymentElement = elements.create("payment", options);
    paymentElement.mount(paymentContainer.value);

    loadingStripe.value = false;
});

async function submit() {
    loading.value = true;
    const redirectRoute = router.resolve({
        name: "payment-status",
        params: { id: paymentStore.payment.id },
    });
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
        <div>{{ paymentStore.article.description }}</div>
        <div class="text-xl">
            Total:
            <span class="font-bold">{{ paymentStore.payment.amount }} CHF</span>
        </div>
        <hr />
        <div ref="paymentContainer"></div>
        <hr />
        <Alert v-if="paymentStore.payment.purpose === 'buy-tokens'">
            <TriangleAlert />
            <AlertTitle>Attention</AlertTitle>
            <AlertDescription>
                Les jetons ne sont pas remboursables. Merci pour votre soutien,
                amusez-vous bien !
            </AlertDescription>
        </Alert>
        <Button class="w-full" variant="outline" @click="paymentStore.cancel()">
            Annuler
        </Button>
        <Button type="submit" :disabled="loading || loadingStripe">
            <Spinner v-if="loading" />
            Continuer
        </Button>
    </form>
</template>
