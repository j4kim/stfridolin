<script setup>
import { loadStripe } from "@stripe/stripe-js";
import { computed, onMounted, ref, useTemplateRef, watch } from "vue";
import { Button } from "./ui/button";
import { Alert, AlertDescription, AlertTitle } from "./ui/alert";
import { TriangleAlert } from "lucide-vue-next";
import { toast } from "vue-sonner";
import Spinner from "./ui/spinner/Spinner.vue";
import { useRouter } from "vue-router";
import { usePaymentStore } from "@/stores/payment";
import Switch from "./ui/switch/Switch.vue";
import Label from "./ui/label/Label.vue";
import { api } from "@/api";

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

const coverFees = ref(false);
const toggling = ref(false);

watch(coverFees, (newValue) => {
    toggling.value = true;
    api("payments.toggle-cover-fees")
        .params({ payment: paymentStore.payment.id })
        .data({ coverFees: newValue })
        .put()
        .finally(() => (toggling.value = false));
});
</script>

<template>
    <form class="mb-8 flex flex-col gap-2 px-4" @submit.prevent="submit">
        <div>{{ intent.metadata.article_description }}</div>
        <div class="text-xl">
            Total:
            <Spinner v-if="toggling" class="mr-1 inline" />
            <span class="font-bold">{{ intent.amount / 100 }} CHF</span>
        </div>
        <div class="flex items-center space-x-2">
            <Switch id="cover-fees" v-model="coverFees" :disabled="toggling" />
            <Label for="cover-fees" class="font-normal">
                Couvrir les frais de transaction
                <span
                    :class="{ invisible: !coverFees || toggling }"
                    class="opacity-80"
                >
                    Merci 🙏
                </span>
            </Label>
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
        <Button type="submit" :disabled="loading || loadingStripe || toggling">
            <Spinner v-if="loading || toggling" />
            Continuer
        </Button>
    </form>
</template>
