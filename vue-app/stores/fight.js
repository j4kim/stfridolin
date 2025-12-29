import { defineStore } from "pinia";
import { ref } from "vue";
import { get, put } from "@/api";

export const useFightStore = defineStore("fight", () => {
    const fight = ref(null);

    async function fetchCurrentFight() {
        fight.value = await get("fights.current");
    }

    async function endFight() {
        const data = await put("fights.end");
        console.log("fight ended", data);
    }

    return {
        fight,
        fetchCurrentFight,
        endFight,
    };
});
