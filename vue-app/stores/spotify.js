import { defineStore } from "pinia";
import { computed, ref, watch } from "vue";
import { get } from "@/api";

export const useSpotifyStore = defineStore("spotify", () => {
    const playback = ref(null);
    const error = ref(null);

    const t0 = ref(Date.now());
    const clockInterval = ref(null);

    async function getPlaybackState() {
        playback.value = null;
        error.value = null;
        try {
            playback.value = await get("spotify.playback-state");
            if (playback.value.is_playing) {
                restartClock();
            } else {
                clearInterval(clockInterval.value);
            }
            computeProgressRatio();
        } catch (e) {
            if (e.response?.data?.exception) {
                error.value = e.response.data.exception;
            } else {
                throw e;
            }
        }
    }

    const track = computed(() => {
        if (!playback.value) return null;
        const item = playback.value.item;
        return {
            img_url: item?.album.images[0].url,
            name: item?.name,
            artist_name: item?.artists.map((a) => a.name).join(", "),
            duration: item?.duration_ms,
            progress: playback.value.progress_ms,
            is_playing: playback.value.is_playing,
        };
    });

    const progressRatio = ref(0);

    function computeProgressRatio() {
        const delta = Date.now() - t0.value;
        const progress = track.value.progress + delta;
        progressRatio.value = progress / track.value.duration;
    }

    function restartClock() {
        t0.value = Date.now();
        clearInterval(clockInterval.value);
        clockInterval.value = setInterval(computeProgressRatio, 1000);
    }

    watch(progressRatio, (ratio) => {
        if (ratio >= 1) {
            clearInterval(clockInterval.value);
            getPlaybackState();
        }
    });

    return { playback, getPlaybackState, track, progressRatio };
});
