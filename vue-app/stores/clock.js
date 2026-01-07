import { defineStore } from "pinia";
import { computed, ref, watch } from "vue";
import { useSpotifyStore } from "./spotify";
import { useFightStore } from "./fight";
import { useClientStore } from "./client";

const END_BUFFER_TIME = 10_000;

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

    const approachingEnd = computed(
        () => progress.value.rest < END_BUFFER_TIME,
    );

    watch(progress, (value) => {
        if (!value || !spotify.playback?.is_playing) {
            return;
        }

        if (value.percent === 100) {
            spotify.getPlaybackState();
            if (client.isMaster && fight.isEnded && !fight.isFinished) {
                fight.createNext();
            }
        }

        if (
            !client.isMaster ||
            !approachingEnd.value ||
            fight.isEnding ||
            value.percent === 100
        ) {
            return;
        }

        fight.endFight();
    });

    return { startClock, time, progress };
});
