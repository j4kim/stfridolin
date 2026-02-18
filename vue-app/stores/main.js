import { defineStore } from "pinia";
import { ref } from "vue";
import { version as pkgVersion } from "../../package.json";

export const useMainStore = defineStore("main", () => {
    const user = ref(JSON.parse(document.body.dataset.user));

    const { appVersion, appName } = document.body.dataset;

    if (pkgVersion !== appVersion) {
        console.warn(
            `Package (${pkgVersion}) and config (${appVersion}) versions mismatch`,
        );
    }

    const isNavigating = ref(false);

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
        startNavigation,
        endNavigation,
    };
});
