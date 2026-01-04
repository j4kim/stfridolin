import { defineStore } from "pinia";
import { ref } from "vue";
import { get, post, put } from "@/api";
import { pusher } from "@/broadcasting";
import { useSpotifyStore } from "./spotify";

export const useFightStore = defineStore("fight", () => {
    const spotify = useSpotifyStore();

    const fight = ref(null);

    async function fetchCurrentFight() {
        fight.value = await get("fights.current");
    }

    async function endFight() {
        const data = await put("fights.end");
    }

    async function endFightAsap(rest) {
        const t = Date.now();
        fight.value.is_ending = true;
        try {
            const data = await put("fights.end", { silent: true });
            console.log("endFightAsap", data);
            if (data.error) {
                console.warn(data.error);
            } else {
                fight.value.is_ended = true;
                prepareNext(rest - (Date.now() - t), data.winner);
            }
        } finally {
            fight.value.is_ending = false;
        }
    }

    async function tossEndFight(rest) {
        const t = Date.now();
        fight.value.is_ending = true;
        try {
            const data = await put("fights.end", { toss: true });
            console.log("tossEndFight", data);
            fight.value.is_ended = true;
            prepareNext(rest - (Date.now() - t), data.winner);
        } finally {
            fight.value.is_ending = false;
        }
    }

    function prepareNext(rest, nextTrack) {
        console.log("prepareNext", rest, nextTrack);
        setTimeout(() => {
            createNext();
            spotify.playTrack(nextTrack.spotify_uri);
        }, rest - 1_000);
    }

    async function createNext() {
        console.log("createNext");
        const data = await post("fights.create-next");
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
        endFightAsap,
        tossEndFight,
        createNext,
    };
});
