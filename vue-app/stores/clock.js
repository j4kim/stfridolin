import { defineStore } from "pinia";
import { computed, ref, watch } from "vue";
import { useSpotifyStore } from "./spotify";
import { useFightStore } from "./fight";
import { useClientStore } from "./client";

export const useClockStore = defineStore("clock", () => {
    const spotify = useSpotifyStore();
    const fight = useFightStore();
    const client = useClientStore();

    const time = ref(Date.now());

    function startClock() {
        setInterval(() => (time.value = Date.now()), 1000);
    }

    const t0 = ref(null);

    watch(
        () => spotify.playback,
        (value) => {
            t0.value = value.is_playing ? Date.now() : null;
        },
    );

    const progress = computed(() => {
        if (!spotify.playback) return null;
        const delta = t0.value ? time.value - t0.value : 0;
        const progress = spotify.playback.progress_ms + delta;
        const ratio = progress / spotify.track.duration;
        const percent = Math.max(0, Math.min(100, 100 * ratio));
        const rest = spotify.track.duration - progress;
        return { progress, rest, percent };
    });

    watch(progress, (value) => {
        if (!value || !spotify.playback?.is_playing) {
            return;
        }

        if (value.percent === 100) {
            spotify.getPlaybackState();
        }

        if (!client.isMaster || value.rest > 20_000 || fight.fight.is_ended) {
            return;
        }

        fight.endFight(true);
    });

    return { startClock, time, progress };
});
