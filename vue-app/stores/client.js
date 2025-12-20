import { get, post } from "@/api";
import { pusher } from "@/broadcasting";
import { useSessionStorage } from "@vueuse/core";
import { defineStore } from "pinia";
import { computed, ref, watch } from "vue";
import { useMainStore } from "./main";

export const useClientStore = defineStore("client", () => {
    const clientId = useSessionStorage("clientId", sessionStorage.clientId);

    const masterId = ref(null);

    async function getMasterClientId() {
        masterId.value = await get("master-client-id.get");
    }

    async function setAsMaster() {
        await post("master-client-id.set", { clientId: clientId.value });
    }

    const isMaster = computed(() => clientId.value == masterId.value);

    pusher.subscribe("master").bind("MasterClientChanged", (data) => {
        masterId.value = data.clientId;
    });

    watch(
        isMaster,
        (value) => {
            document.title = value ? "Master" : useMainStore().appName;
        },
        { immediate: true },
    );

    return {
        clientId,
        masterId,
        getMasterClientId,
        setAsMaster,
        isMaster,
    };
});
