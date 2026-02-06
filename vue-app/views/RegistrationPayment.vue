<script setup>
import StripePayment from "@/components/StripePayment.vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { useArticlesStore } from "@/stores/articles";
import { useGuestStore } from "@/stores/guest";
import { usePaymentStore } from "@/stores/payment";
import titleSvg from "@/title.svg";
import { computed, ref } from "vue";

const guestStore = useGuestStore();

const paymentStore = usePaymentStore();

paymentStore.payment = null;

const articlesStore = useArticlesStore();

const article = computed(() => articlesStore.byName["registration"]);

const loading = ref(false);

const name = ref("");

const total = ref(30);

const guest = ref(null);

async function submit() {
    loading.value = true;
    try {
        guest.value = await guestStore.createGuest(name.value);
        await paymentStore.createPayment(
            article.value,
            "registration",
            guest.value,
        );
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <div class="mx-auto max-w-xl p-8">
        <img class="mx-auto max-w-xl p-12" :src="titleSvg" />

        <h2 class="my-4 text-xl font-bold">Paiement de l'inscription</h2>

        <Spinner v-if="loading" class="mx-auto size-8" />
        <StripePayment
            v-else-if="paymentStore.payment"
            :cancelable="false"
            redirectRouteName="registration-payment-status"
            :guest="guest"
        />
        <form v-else class="flex flex-col gap-4" @submit.prevent="submit">
            <Input
                v-model="name"
                type="text"
                placeholder="Nom Complet"
                required
            />
            <Button :disabled="!article || loading" type="submit">
                Payer {{ total }} CHF
            </Button>
        </form>
    </div>
</template>
