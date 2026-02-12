<script setup>
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { usePaymentStore } from "@/stores/payment";
import { CheckCircle2Icon, RefreshCcw, TriangleAlert } from "lucide-vue-next";
import { computed, ref } from "vue";
import { useRoute } from "vue-router";

const paymentStore = usePaymentStore();
const route = useRoute();

const loading = ref(true);

function fetch(reload = false) {
    loading.value = true;
    return paymentStore
        .fetchPayment(route.params.id, reload, route.query.guest)
        .finally(() => (loading.value = false));
}

const paymentIntent = computed(() => paymentStore.payment?.stripe_data);

const status = computed(() => paymentStore.payment?.stripe_status);

const paymentError = computed(() => paymentIntent.value?.last_payment_error);

const justCreated = computed(
    () => status.value === "requires_payment_method" && !paymentError.value,
);

const waiting = computed(
    () => loading.value || status.value === "processing" || justCreated.value,
);

const showReloadButton = ref(false);

async function fetchAndRetry() {
    await fetch();
    if (!waiting.value) return; // all good
    // payment is still waiting update
    // wait for 2 seconds
    setTimeout(async () => {
        if (!waiting.value) return; // update received from websocket in the meantime
        await fetch(); // retry if we missed update
        if (!waiting.value) return; // all good now
        // show manual reload button if we still don't have any update after 2 more seconds
        setTimeout(() => {
            if (!waiting.value) return;
            showReloadButton.value = true;
        }, 2000);
    }, 2000);
}

fetchAndRetry();
</script>

<template>
    <Alert v-if="waiting">
        <Spinner />
        <AlertTitle>En attente...</AlertTitle>
        <AlertDescription v-if="showReloadButton">
            On dirait qu'on est bloqué... Cliquez ci-dessous pour recharger le
            statut de paiement.
            <Button class="mt-2 w-full" @click="() => fetch(true)">
                <Spinner v-if="loading" />
                <RefreshCcw v-else />
                Recharger
            </Button>
        </AlertDescription>
    </Alert>

    <Alert v-else-if="status === 'succeeded'">
        <CheckCircle2Icon />
        <slot name="success_alert_content">
            <AlertTitle>Paiement réussi ! 🎉</AlertTitle>
            <AlertDescription> Merci pour votre soutien !</AlertDescription>
        </slot>
    </Alert>

    <Alert v-else-if="paymentError">
        <TriangleAlert />
        <AlertTitle>Paiement échoué</AlertTitle>
        <slot
            v-if="status === 'requires_payment_method'"
            name="requires_payment_method_error"
        >
        </slot>
        <AlertDescription v-else-if="paymentError?.message">
            {{ paymentError.message }}
        </AlertDescription>
        <AlertDescription v-else-if="status">
            Statut: {{ status }}
        </AlertDescription>
    </Alert>
</template>
