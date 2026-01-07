import { defineStore } from "pinia";
import { ref } from "vue";
import { api } from "@/api";
import { pusher } from "@/broadcasting";
import { useSpotifyStore } from "./spotify";

export const useFightStore = defineStore("fight", () => {
    const spotify = useSpotifyStore();

    const fight = ref(null);

    const isEnded = ref(false);
    const isEnding = ref(false);
    const isFinished = ref(false);

    async function fetchCurrentFight() {
        fight.value = await api("fights.current").noToast().get();
    }

    async function endFight() {
        isEnding.value = true;
        await api("fights.end").params(fight.value.id).put();
    }

    async function createNext() {
        if (fight.value) {
            isFinished.value = true;
            await api("fights.create-next").params(fight.value.id).post();
        } else {
            await api("fights.create-first").post();
        }
    }

    pusher.subscribe("fights").bind("EndFight", (data) => {
        isEnded.value = true;
    });

    pusher.subscribe("fights").bind("NewFight", (data) => {
        fight.value = data.fight;
        isEnded.value = false;
        isEnding.value = false;
        isFinished.value = false;
    });

    return {
        fight,
        isEnded,
        isEnding,
        isFinished,
        fetchCurrentFight,
        endFight,
        createNext,
    };
});
