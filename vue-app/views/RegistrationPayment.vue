<script setup>
import PublicLayout from "@/components/PublicLayout.vue";
import StripePayment from "@/components/StripePayment.vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import { useArticlesStore } from "@/stores/articles";
import { useGuestStore } from "@/stores/guest";
import { usePaymentStore } from "@/stores/payment";
import { Minus, Plus } from "lucide-vue-next";
import { computed, ref } from "vue";

const guestStore = useGuestStore();

const paymentStore = usePaymentStore();

paymentStore.payment = null;

const articlesStore = useArticlesStore();

const article = computed(() => articlesStore.byName["registration"]);

const loading = ref(false);

const names = ref([""]);
const remarks = ref("");
const missingNames = computed(() => names.value.some((n) => !n));

const total = computed(() => 30 * names.value.length);

const guest = ref(null);

async function submit() {
    loading.value = true;
    try {
        const guests = await guestStore.createGuests(names.value);
        guest.value = guests[0];
        const data = {
            purpose: "registration",
            guestNames: names.value.join(";"),
            guestIds: guests.map((g) => g.id).join(";"),
            remarks: remarks.value,
        };
        if (names.value.length > 1) {
            data.quantity = names.value.length;
            data.description = `${article.value.description} pour ${data.quantity} personnes`;
        }
        await paymentStore.createPayment(article.value, data, guest.value);
        guestStore.subscribeToBroadcastEvents(`guest-${guest.value.id}`);
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <PublicLayout>
        <h2 class="my-4 text-xl font-bold">Paiement de l'inscription</h2>

        <Spinner v-if="loading" class="mx-auto size-8" />
        <StripePayment
            v-else-if="paymentStore.payment"
            redirectRouteName="registration-payment-status"
            :guest="guest"
            cancelButtonText="Retour"
        />
        <form v-else class="flex flex-col gap-4" @submit.prevent="submit">
            <p class="flex items-center gap-2">
                Je paye pour
                <Button
                    variant="outline"
                    size="icon"
                    @click="names.pop()"
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
                    @click="names.push('')"
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
            <Textarea
                v-model="remarks"
                placeholder="Remarques, allergies etc. (optionnel)"
            />
            <Button :disabled="!article || missingNames" type="submit">
                Payer {{ total }} CHF
            </Button>
        </form>
    </PublicLayout>
</template>
