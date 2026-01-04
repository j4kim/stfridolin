import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { get, put } from "@/api";

export const useSpotifyStore = defineStore("spotify", () => {
    const devices = ref([]);
    const playback = ref(null);
    const playbackError = ref(null);

    async function getDevices() {
        get("spotify.devices").then((data) => (devices.value = data));
    }

    async function selectDevice(deviceId) {
        await put("spotify.select-device", deviceId);
        await getDevices();
    }

    async function getPlaybackState() {
        playback.value = null;
        playbackError.value = null;
        try {
            playback.value = await get("spotify.playback-state");
        } catch (e) {
            if (e.response?.data?.exception) {
                playbackError.value = e.response.data.exception;
            } else {
                throw e;
            }
        }
    }

    async function playTrack(uri) {
        const data = await put("spotify.play-track", uri);
        setTimeout(async () => await spotify.getPlaybackState(), 500);
    }

    const track = computed(() => {
        if (!playback.value) return null;
        const item = playback.value.item;
        return {
            img_url: item?.album.images[0].url,
            img_thumbnail_url: item?.album.images[2].url,
            name: item?.name,
            artist_name: item?.artists.map((a) => a.name).join(", "),
            duration: item?.duration_ms,
        };
    });

    const isPlaying = computed(() => playback.value?.is_playing ?? false);

    return {
        devices,
        playback,
        playbackError,
        getDevices,
        selectDevice,
        getPlaybackState,
        playTrack,
        track,
        isPlaying,
    };
});
