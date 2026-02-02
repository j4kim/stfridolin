import { api } from "@/api";
import { defineStore } from "pinia";
import { ref } from "vue";

export const usePaymentStore = defineStore("payment", () => {
    const payment = ref(null);

    function cancel() {
        payment.value = null;
    }

    async function createPayment(offer) {
        payment.value = await api("payments.store").data(offer).post();
        return payment.value;
    }

    async function fetchPayment(id) {
        payment.value = null;
        payment.value = await api("payments.get").params(id).get();
        return payment.value;
    }

    return { payment, cancel, createPayment, fetchPayment };
});
