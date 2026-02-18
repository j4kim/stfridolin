import { api } from "@/api";
import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { useArticlesStore } from "@/stores/articles";

export const usePaymentStore = defineStore("payment", () => {
    const articlesStore = useArticlesStore();

    const stripePk = document.body.dataset.stripePk;

    const payment = ref(null);

    function cancel() {
        payment.value = null;
    }

    async function createPayment(article, data = {}, guest = null) {
        payment.value = await api("payments.store")
            .asGuest(guest?.id)
            .params(article.id)
            .data(data)
            .post();
        return payment.value;
    }

    async function fetchPayment(id, reload = false, guestId = null) {
        payment.value = null;
        payment.value = await api("payments.get")
            .asGuest(guestId)
            .params({ payment: id, reload })
            .get();
        return payment.value;
    }

    function setPayment(updatedPayment) {
        if (payment.value && payment.value.id != updatedPayment.id) {
            return;
        }
        payment.value = updatedPayment;
    }

    const article = computed(() => {
        if (!payment.value) return null;
        return articlesStore.byId[payment.value.article_id];
    });

    const twintPaymentLink = computed(() => {
        const base = document.body.dataset.twintPaymentLink;
        const amount = encodeURIComponent(payment.value.amount);
        const trxInfo = encodeURIComponent(
            `${payment.value.description} (id de pmt:${payment.value.id})`,
        );
        return `${base}&amount=${amount}&trxInfo=${trxInfo}`;
    });

    return {
        stripePk,
        payment,
        cancel,
        createPayment,
        fetchPayment,
        setPayment,
        article,
        twintPaymentLink,
    };
});
