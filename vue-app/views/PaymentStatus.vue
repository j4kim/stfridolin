<script setup>
import Layout from "@/components/Layout.vue";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { usePaymentStore } from "@/stores/payment";
import { CheckCircle2Icon, TriangleAlert } from "lucide-vue-next";
import { computed } from "vue";
import { useRoute } from "vue-router";

const paymentStore = usePaymentStore();
const route = useRoute();

paymentStore.fetchPayment(route.params.id);

const status = computed(
    () => paymentStore.payment?.stripe_data.status ?? "loading",
);
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">Statut du paiement</h2>
        <div class="flex flex-col items-center justify-center gap-4 px-4">
            <Spinner
                class="size-8"
                v-if="status === 'loading' || status === 'processing'"
            />
            <Alert v-if="status === 'succeeded'">
                <CheckCircle2Icon />
                <AlertTitle>Paiement réussi ! 🎉</AlertTitle>
                <AlertDescription> Merci pour votre soutien !</AlertDescription>
            </Alert>
            <Alert v-else>
                <TriangleAlert />
                <AlertTitle>Paiement échoué</AlertTitle>
                <AlertDescription
                    v-if="
                        paymentStore.payment.stripe_data.last_payment_error
                            ?.message
                    "
                >
                    {{
                        paymentStore.payment.stripe_data.last_payment_error
                            .message
                    }}
                </AlertDescription>
                <AlertDescription v-else>
                    Statut: {{ paymentStore.payment.stripe_data.status }}
                </AlertDescription>
            </Alert>
        </div>
    </Layout>
</template>
