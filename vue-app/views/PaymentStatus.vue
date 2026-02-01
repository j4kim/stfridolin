<script setup>
import Layout from "@/components/Layout.vue";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { usePaymentStore } from "@/stores/payment";
import {
    ArrowLeft,
    CheckCircle2Icon,
    Home,
    TriangleAlert,
} from "lucide-vue-next";
import { computed, ref } from "vue";
import { useRoute } from "vue-router";

const paymentStore = usePaymentStore();
const route = useRoute();

const loading = ref(true);

paymentStore
    .fetchPayment(route.params.id)
    .finally(() => (loading.value = false));

const paymentIntent = computed(() => paymentStore.payment?.stripe_data);

const status = computed(() => paymentIntent.value?.status);

const paymentError = computed(() => paymentIntent.value?.last_payment_error);
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">Statut du paiement</h2>
        <div class="flex flex-col justify-center gap-4 px-4">
            <Spinner class="size-8" v-if="loading || status === 'processing'" />
            <Alert v-if="status === 'succeeded'">
                <CheckCircle2Icon />
                <AlertTitle>Paiement réussi ! 🎉</AlertTitle>
                <AlertDescription> Merci pour votre soutien !</AlertDescription>
            </Alert>
            <Alert v-else-if="paymentIntent">
                <TriangleAlert />
                <AlertTitle>Paiement échoué</AlertTitle>
                <AlertDescription v-if="status === 'requires_payment_method'">
                    Vous pouvez réessayer avec un autre moyen de paiement. Ou
                    alors aller au kiosque pour payer en cash.
                    <RouterLink
                        class="mt-2 w-full"
                        :to="{ name: 'payment' }"
                        v-if="paymentStore.payment"
                    >
                        <Button class="w-full">
                            <ArrowLeft />
                            Retour à la page de paiement
                        </Button>
                    </RouterLink>
                </AlertDescription>
                <AlertDescription v-else-if="paymentError?.message">
                    {{ paymentError.message }}
                </AlertDescription>
                <AlertDescription v-else-if="status">
                    Statut: {{ status }}
                </AlertDescription>
            </Alert>
            <RouterLink :to="{ name: 'home' }">
                <Button class="w-full" variant="outline">
                    <Home />
                    Retour à l'accueil
                </Button>
            </RouterLink>
        </div>
    </Layout>
</template>
