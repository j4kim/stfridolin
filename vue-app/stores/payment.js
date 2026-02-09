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
        const request = api("payments.store");
        if (guest) {
            request.config.headers["X-Guest-Id"] = guest.id;
        }
        payment.value = await request.params(article.id).data(data).post();
        return payment.value;
    }

    async function fetchPayment(id, reload = false, guestId = null) {
        payment.value = null;
        const request = api("payments.get");
        if (guestId) {
            request.config.headers["X-Guest-Id"] = guestId;
        }
        payment.value = await request.params({ payment: id, reload }).get();
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

    return {
        stripePk,
        payment,
        cancel,
        createPayment,
        fetchPayment,
        setPayment,
        article,
    };
});
