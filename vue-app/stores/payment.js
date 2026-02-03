import { api } from "@/api";
import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { useArticlesStore } from "@/stores/articles";

export const usePaymentStore = defineStore("payment", () => {
    const articlesStore = useArticlesStore();

    const payment = ref(null);

    function cancel() {
        payment.value = null;
    }

    async function createPayment(article, purpose = null) {
        payment.value = await api("payments.store")
            .params(article.id)
            .data({ purpose })
            .post();
        return payment.value;
    }

    async function fetchPayment(id, reload = false) {
        payment.value = null;
        payment.value = await api("payments.get")
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

    return {
        payment,
        cancel,
        createPayment,
        fetchPayment,
        setPayment,
        article,
    };
});
