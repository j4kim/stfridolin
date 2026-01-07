import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { api } from "@/api";

export const useSpotifyStore = defineStore("spotify", () => {
    const devices = ref([]);
    const playback = ref(null);
    const playbackError = ref(null);
    const playbackInterval = ref(null);

    async function getDevices() {
        devices.value = await api("spotify.devices").get();
    }

    async function selectDevice(deviceId) {
        await api("spotify.select-device").params(deviceId).put();
        await getDevices();
    }

    async function getPlaybackState() {
        playbackError.value = null;
        try {
            const t0 = Date.now();
            playback.value = await api("spotify.playback-state").get();
            const dt = Date.now() - t0;
            playback.value.progress_ms += dt / 2;
        } catch (e) {
            playback.value = null;
            if (e.response?.data?.exception) {
                playbackError.value = e.response.data.exception;
            } else {
                throw e;
            }
        }
    }

    function setPlaybackInterval() {
        playbackInterval.value = setInterval(getPlaybackState, 12_000);
    }

    function clearPlaybackInterval() {
        clearInterval(playbackInterval.value);
    }

    async function playTrack(uri) {
        const data = await api("spotify.play-track").params(uri).put();
        setTimeout(async () => await getPlaybackState(), 500);
    }

    async function skipToNext(uri) {
        const data = await api("spotify.skip").params(uri).post();
        setTimeout(async () => await getPlaybackState(), 500);
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

    return {
        devices,
        playback,
        playbackError,
        getDevices,
        selectDevice,
        getPlaybackState,
        setPlaybackInterval,
        clearPlaybackInterval,
        playTrack,
        skipToNext,
        track,
    };
});
