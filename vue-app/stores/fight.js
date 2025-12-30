import { defineStore } from "pinia";
import { ref } from "vue";
import { get, post, put } from "@/api";
import { pusher } from "@/broadcasting";

export const useFightStore = defineStore("fight", () => {
    const fight = ref(null);

    async function fetchCurrentFight() {
        fight.value = await get("fights.current");
    }

    async function endFight() {
        const data = await put("fights.end");
        console.log("fight ended", data);
    }

    async function createNext() {
        const data = await post("fights.create-next");
        console.log("new fight created", data);
    }

    pusher.subscribe("fights").bind("EndFight", (data) => {
        fight.value.is_ended = true;
    });

    return {
        fight,
        fetchCurrentFight,
        endFight,
        createNext,
    };
});
