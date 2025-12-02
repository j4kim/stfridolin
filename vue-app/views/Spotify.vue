<script setup>
import { ref } from "vue";
import { get, put } from "../api";
import { route as ziggy } from "../../vendor/tightenco/ziggy";
import { useRoute } from "vue-router";
import SearchIcon from "../icons/SearchIcon.vue";
import { watchDebounced } from "@vueuse/core";
import PlayIcon from "../icons/PlayIcon.vue";

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

const tracks = ref([]);
const searchQuery = ref("");
watchDebounced(searchQuery, searchTracks, { debounce: 500 });

async function searchTracks() {
    const data = await get("spotify.search-tracks", { q: searchQuery.value });
    tracks.value = data.items;
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

        <div>
            <label class="input">
                <SearchIcon />
                <input
                    type="search"
                    placeholder="Search track"
                    v-model="searchQuery"
                />
            </label>
        </div>

        <ul
            class="list bg-base-100 rounded-box max-w-lg shadow-md"
            v-if="tracks.length"
        >
            <li v-for="track in tracks" class="list-row">
                <div>
                    <img
                        class="rounded-box size-10"
                        :src="track.album.images[2].url"
                    />
                </div>
                <div>
                    <div>{{ track.name }}</div>
                    <div class="text-xs font-semibold opacity-60">
                        {{ track.artists.map((a) => a.name).join(", ") }}
                    </div>
                </div>
                <button class="btn btn-square btn-ghost">
                    <PlayIcon />
                </button>
            </li>
        </ul>
    </div>
</template>
