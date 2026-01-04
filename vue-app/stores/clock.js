import { defineStore } from "pinia";
import { computed, ref, watch } from "vue";
import { useSpotifyStore } from "./spotify";
import { useClientStore } from "./client";
import { useFightStore } from "./fight";

export const useClockStore = defineStore("clock", () => {
    const spotify = useSpotifyStore();
    const client = useClientStore();
    const fight = useFightStore();

    const time = ref(Date.now());

    function startClock() {
        setInterval(() => (time.value = Date.now()), 1000);
    }

    const t0 = ref(null);

    watch(
        () => spotify.isPlaying,
        (value) => {
            t0.value = value ? Date.now() : null;
        },
    );

    const progress = computed(() => {
        if (!spotify.playback) return null;
        const delta = t0.value ? time.value - t0.value : 0;
        const progress = spotify.playback.progress_ms + delta;
        const ratio = progress / spotify.track.duration;
        const percent = Math.min(100, 100 * ratio);
        const rest = spotify.track.duration - progress;
        return { progress, rest, percent };
    });

    watch(progress, (value) => {
        if (!value || !spotify.isPlaying) {
            return;
        }

        if (value.percent === 100) {
            console.log("100%, call getPlaybackState");
            spotify.getPlaybackState();
        }

        if (
            !client.isMaster ||
            value.rest > 30_000 ||
            fight.fight.is_ending ||
            fight.fight.is_ended
        ) {
            return;
        }

        // from here, we deal with the end of the fight
        console.log("rest", value.rest);

        if (value.rest > 5_000) {
            fight.endFightAsap(value.rest);
        } else {
            fight.tossEndFight(value.rest);
        }
    });

    return { startClock, time, progress };
});
