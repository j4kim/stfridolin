import { defineStore } from "pinia";
import { ref } from "vue";
import { get, post, put } from "../api";

export const useMainStore = defineStore("main", () => {
    const user = ref(JSON.parse(document.body.dataset.user));

    async function updateUser(form) {
        await put("users.update", 1, form);
    }

    async function flushSession() {
        await post("flush-session");
    }

    async function inspire() {
        const data = await get("inspire");
        alert(data.message);
    }

    return {
        appVersion: document.body.dataset.appVersion,
        appName: document.body.dataset.appName,
        csrfToken: document.body.dataset.csrfToken,
        user,
        updateUser,
        flushSession,
        inspire,
    };
});
