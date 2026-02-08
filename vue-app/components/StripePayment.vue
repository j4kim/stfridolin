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

const props = defineProps({
    cancelable: {
        type: Boolean,
        default: true,
    },
    redirectRouteName: {
        type: String,
        default: "payment-status",
    },
    guest: Object,
});

const paymentStore = usePaymentStore();

const router = useRouter();

const loading = ref(false);
const loadingStripe = ref(true);
const ready = ref(false);

let stripe = null;
let elements = null;

const paymentContainer = useTemplateRef("paymentContainer");

const intent = computed(() => paymentStore.payment.stripe_data);

onMounted(async () => {
    stripe = await loadStripe(paymentStore.stripePk);

    const clientSecret = intent.value.client_secret;

    const appearance = {
        theme: "night",
        labels: "floating",
        inputs: "condensed",
    };

    elements = stripe.elements({ clientSecret, appearance });

    const options = {
        layout: {
            type: "tabs",
            defaultCollapsed: true,
        },
    };

    const paymentElement = elements.create("payment", options);
    paymentElement.mount(paymentContainer.value);

    paymentElement.on("change", ({ complete, collapsed }) => {
        ready.value = complete && !collapsed;
    });

    loadingStripe.value = false;
});

async function submit() {
    loading.value = true;
    const redirectRoute = router.resolve({
        name: props.redirectRouteName,
        params: { id: paymentStore.payment.id, guest: props.guest?.id },
        query: props.guest ? { guest: props.guest.id } : undefined,
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
    <form class="mb-8 flex flex-col gap-2" @submit.prevent="submit">
        <div class="flex justify-between gap-2 text-lg">
            <div>{{ intent.description }}</div>
            <div>
                <Spinner v-if="toggling" class="mr-1 mb-1 inline" />
                <span class="font-extrabold"
                    >{{ intent.amount / 100 }}&nbsp;CHF</span
                >
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <Switch id="cover-fees" v-model="coverFees" :disabled="toggling" />
            <Label for="cover-fees" class="font-normal">
                Couvrir les frais de transaction
                <span
                    :class="{ invisible: !coverFees || toggling }"
                    class="text-muted-foreground"
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
            <div class="col-start-2">
                <span> Attention: </span>
                <span class="text-muted-foreground">
                    Les jetons ne sont pas remboursables. Amusez-vous bien !
                </span>
            </div>
        </Alert>
        <Button
            type="submit"
            size="lg"
            :disabled="loading || loadingStripe || toggling || !ready"
        >
            <Spinner v-if="loading" />
            Continuer
        </Button>
        <Button
            v-if="cancelable"
            class="w-full"
            variant="ghost"
            @click="paymentStore.cancel()"
        >
            Annuler
        </Button>
    </form>
</template>
