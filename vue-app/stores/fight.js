import { defineStore } from "pinia";
import { ref } from "vue";
import { api } from "@/api";
import { pusher } from "@/broadcasting";
import { useSpotifyStore } from "./spotify";

export const useFightStore = defineStore("fight", () => {
    const spotify = useSpotifyStore();

    const fight = ref(null);

    async function fetchCurrentFight() {
        fight.value = await api("fights.current").noToast().get();
    }

    async function endFight() {
        fight.value.is_ending = true;
        try {
            await api("fights.end", fight.value.id).put();
        } catch (error) {
            fight.value.is_ending = false;
        }
    }

    async function createNext() {
        if (fight.value) {
            fight.value.is_finished = true;
            await api("fights.create-next", fight.value.id).post();
        } else {
            await api("fights.create-first").post();
        }
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
