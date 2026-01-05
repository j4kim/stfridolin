import { defineStore } from "pinia";
import { ref } from "vue";
import { api } from "@/api";
import { pusher } from "@/broadcasting";
import { useSpotifyStore } from "./spotify";

export const useFightStore = defineStore("fight", () => {
    const spotify = useSpotifyStore();

    const fight = ref(null);

    async function fetchCurrentFight() {
        fight.value = await api("fights.current").get();
    }

    async function endFight(noToast = false) {
        const data = await api("fights.end").noToast(noToast).put();
        if (data.winner) {
            await spotify.addToQueue(data.winner);
        }
    }

    async function createNext() {
        const data = await api("fights.create-next").post();
    }

    pusher.subscribe("fights").bind("EndFight", (data) => {
        fight.value.is_ended = true;
    });

    pusher.subscribe("fights").bind("NewFight", (data) => {
        fight.value = data.fight;
    });

    return {
        fight,
        fetchCurrentFight,
        endFight,
        createNext,
    };
});
