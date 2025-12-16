import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { get } from "../api";

export const useSpotifyStore = defineStore("spotify", () => {
    const playback = ref(null);
    const error = ref(null);

    async function getPlaybackState() {
        playback.value = null;
        error.value = null;
        try {
            playback.value = await get("spotify.playback-state");
        } catch (e) {
            if (e.response?.data?.exception) {
                error.value = e.response.data.exception;
            } else {
                throw e;
            }
        }
    }

    const track = computed(() => {
        const item = playback.value?.item;
        if (!item) return null;
        return {
            img_url: item.album.images[0].url,
            name: item.name,
            artist_name: item.artists.map((a) => a.name).join(", "),
            progress: playback.value.progress_ms / item.duration_ms,
        };
    });

    return { playback, getPlaybackState, track };
});
