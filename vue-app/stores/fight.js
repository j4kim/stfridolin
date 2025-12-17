import { defineStore } from "pinia";
import { ref } from "vue";
import { get } from "../api";

export const useFightStore = defineStore("fight", () => {
    const fight = ref(null);

    async function fetchCurrentFight() {
        fight.value = await get("fights.current");
    }

    return {
        fight,
        fetchCurrentFight,
    };
});
