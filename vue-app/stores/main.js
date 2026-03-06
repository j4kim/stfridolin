import { defineStore } from "pinia";
import { ref } from "vue";
import { api } from "@/api";
import { version as pkgVersion } from "../../package.json";
import { pusher } from "@/broadcasting";


export const useMainStore = defineStore("main", () => {
    const user = ref(JSON.parse(document.body.dataset.user));

    const isJukeboxActive = ref(JSON.parse(document.body.dataset.games).find((e) => e.name == 'jukeboxe').active);

    const { appVersion, appName } = document.body.dataset;

    if (pkgVersion !== appVersion) {
        console.warn(
            `Package (${pkgVersion}) and config (${appVersion}) versions mismatch`,
        );
    }
    const isNavigating = ref(false);


    pusher.subscribe('set-jukebox-active').bind("SetJukeboxActive", async (data) => {
            isJukeboxActive.value = data.is_active;
        });
 

    let timer;

    function startNavigation() {
        timer = setTimeout(() => {
            isNavigating.value = true;
        }, 100);
    }

    function endNavigation() {
        clearTimeout(timer);
        isNavigating.value = false;
    }

    return {
        appVersion,
        pkgVersion,
        appName,
        user,
        isNavigating,
        isJukeboxActive,
        startNavigation,
        endNavigation,
    };
});
