import { useStorage } from "@vueuse/core";
import { defineStore } from "pinia";

export const useGuestStore = defineStore("guest", () => {
    const guest = useStorage("guest");

    return { guest };
});
