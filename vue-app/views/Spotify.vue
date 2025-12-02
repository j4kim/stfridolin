<script setup>
import { ref } from "vue";
import { get, put } from "../api";
import { route as ziggy } from "../../vendor/tightenco/ziggy";
import { useRoute } from "vue-router";

const error = ref(null);
const playback = ref(null);
const is_playing = ref(false);
const devices = ref([]);

const route = useRoute();

getPlaybackState();
getDevices();

async function getPlaybackState() {
    get("spotify.playback-state")
        .then((data) => {
            playback.value = data;
            is_playing.value = data.is_playing;
        })
        .catch((e) => {
            if (e.response?.data?.exception) {
                error.value = e.response.data.exception;
            } else {
                alert(error.response?.data?.message ?? error.message);
            }
        });
}

async function getDevices() {
    get("spotify.devices").then((data) => (devices.value = data));
}

async function play(params = null) {
    await put("spotify.play", params);
    is_playing.value = true;
}

async function pause() {
    await put("spotify.pause");
    is_playing.value = false;
}

async function selectDevice(deviceId) {
    await put("spotify.select-device", deviceId);
    await getDevices();
}
</script>

<template>
    <div class="flex flex-col gap-8">
        <div v-if="error">
            <p v-if="error === 'App\\Exceptions\\NoSpotifyTokenException'">
                No Spotify Token.
                <a
                    :href="ziggy('spotify-login', { intended: route.path })"
                    class="link-primary"
                >
                    Login to Spotify
                </a>
            </p>
            <p v-if="error === 'App\\Exceptions\\NoSpotifyPlaybackException'">
                No spotify playback.
                <a
                    href="https://open.spotify.com"
                    target="_blank"
                    class="link-primary"
                >
                    Open Spotify
                </a>
            </p>
        </div>

        <div class="devices">
            Devices:
            <div v-for="device in devices" class="flex gap-2">
                <span class="font-semibold">{{ device.name }}</span>
                <span>{{ device.is_active ? "active" : "inactive" }}</span>
                <button
                    class="btn btn-xs btn-soft btn-primary"
                    :class="{ 'btn-disabled': device.selected }"
                    @click="selectDevice(device.id)"
                    v-text="device.selected ? 'selected' : 'select'"
                ></button>
            </div>
        </div>

        <div v-if="playback">
            <img
                class="inline"
                v-if="playback.item.album.images.length"
                :src="
                    playback.item.album.images[
                        playback.item.album.images.length - 1
                    ].url
                "
            />
            {{ playback.item.artists[0].name }} - {{ playback.item.name }}
            <div class="flex items-center gap-1">
                <progress
                    :max="playback.item.duration_ms"
                    :value="playback.progress_ms"
                ></progress>
                <button v-if="is_playing" @click="pause">⏸️</button>
                <button v-else @click="play">▶️</button>
            </div>
        </div>
    </div>
</template>
