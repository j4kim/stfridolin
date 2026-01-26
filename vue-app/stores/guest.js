import { api, getErrorMsg } from "@/api";
import { useStorage } from "@vueuse/core";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useGuestStore = defineStore("guest", () => {
    const guest = useStorage("guest", {});
    const error = ref("");

    async function fetchGuest(key) {
        error.value = "";
        try {
            guest.value = await api("guests.get").params(key).get();
            console.log("guest", guest.value);
        } catch (error) {
            error.value = getErrorMsg(error);
        }
    }

    return { guest, error, fetchGuest };
});
