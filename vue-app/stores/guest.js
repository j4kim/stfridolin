import { api } from "@/api";
import router from "@/router";
import { useStorage } from "@vueuse/core";
import { defineStore } from "pinia";
import { ref } from "vue";

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

    return { guest, error, fetchGuest };
});
