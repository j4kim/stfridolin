import { post } from "@/api";
import { pusher } from "@/broadcasting";
import { useSessionStorage } from "@vueuse/core";
import { defineStore } from "pinia";
import { computed, ref, watch } from "vue";
import { useMainStore } from "./main";

export const useClientStore = defineStore("client", () => {
    const clientId = useSessionStorage("clientId", makeid(16));

    const masterId = ref(document.body.dataset.masterClientId);

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
        setAsMaster,
        isMaster,
    };
});

// https://stackoverflow.com/a/1349426/8345160
function makeid(length) {
    var result = "";
    var characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(
            Math.floor(Math.random() * charactersLength),
        );
    }
    return result;
}
