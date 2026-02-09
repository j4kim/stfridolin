import { api } from "@/api";
import { pusher } from "@/broadcasting";
import router from "@/router";
import { useStorage } from "@vueuse/core";
import { defineStore } from "pinia";
import { computed, ref, watch } from "vue";
import { usePaymentStore } from "./payment";

export const useGuestStore = defineStore("guest", () => {
    const guest = useStorage("guest", {});
    const error = ref(null);

    async function fetchGuest(key) {
        error.value = null;
        try {
            guest.value = await api("guests.get").params(key).noToast().get();
        } catch (e) {
            guest.value = {};
            error.value = e;
            router.push({ name: "guest-auth-form", replace: true });
        }
    }

    async function createGuest(name) {
        return await api("guests.store").data({ name }).post();
    }

    const channelName = computed(() => {
        return guest.value.id ? `guest-${guest.value.id}` : null;
    });

    watch(
        channelName,
        (newChannel, oldChannel) => {
            if (oldChannel) {
                pusher.unsubscribe(oldChannel);
            }
            if (newChannel) {
                subscribeToBroadcastEvents(newChannel);
            }
        },
        { immediate: true },
    );

    function subscribeToBroadcastEvents(channelName) {
        const channel = pusher.subscribe(channelName);

        channel.bind("GuestUpdated", (data) => {
            if (guest.value.id == data.model.id) {
                guest.value = data.model;
            }
        });

        channel.bind("PaymentUpdated", (data) => {
            const paymentStore = usePaymentStore();
            paymentStore.setPayment(data.payment);
        });
    }

    return {
        guest,
        error,
        createGuest,
        fetchGuest,
        subscribeToBroadcastEvents,
    };
});
