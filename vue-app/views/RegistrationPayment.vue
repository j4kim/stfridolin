<script setup>
import StripePayment from "@/components/StripePayment.vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { useArticlesStore } from "@/stores/articles";
import { useGuestStore } from "@/stores/guest";
import { usePaymentStore } from "@/stores/payment";
import titleSvg from "@/title.svg";
import { Minus, Plus } from "lucide-vue-next";
import { computed, ref } from "vue";

const guestStore = useGuestStore();

const paymentStore = usePaymentStore();

paymentStore.payment = null;

const articlesStore = useArticlesStore();

const article = computed(() => articlesStore.byName["registration"]);

const loading = ref(false);

const names = ref([""]);

const total = computed(() => 30 * names.value.length);

const guest = ref(null);

async function submit() {
    loading.value = true;
    try {
        guest.value = await guestStore.createGuest(names.value[0]);
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
            <p class="flex items-center gap-2">
                Je paye pour
                <Button
                    variant="outline"
                    size="icon"
                    @click="names.length--"
                    type="button"
                    :disabled="names.length < 2"
                >
                    <Minus />
                </Button>
                <span class="inline-block w-4 text-center font-bold">{{
                    names.length
                }}</span>
                <Button
                    variant="outline"
                    size="icon"
                    @click="names.length++"
                    type="button"
                >
                    <Plus />
                </Button>
                personne(s)
            </p>
            <template v-for="(name, i) in names">
                <Input
                    v-model="names[i]"
                    type="text"
                    :placeholder="
                        i === 0
                            ? 'Ton prénom et nom'
                            : `Prénom et nom de la ${i + 1}ème personne`
                    "
                    required
                />
            </template>
            <Button :disabled="!article || loading" type="submit">
                Payer {{ total }} CHF
            </Button>
        </form>
    </div>
</template>
