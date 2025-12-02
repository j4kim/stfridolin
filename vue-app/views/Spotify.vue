<script setup>
import { ref } from "vue";
import { get, put } from "../api";
import { route as ziggy } from "../../vendor/tightenco/ziggy";
import { useRoute } from "vue-router";

const error = ref(null);
const playback = ref(null);
const is_playing = ref(false);

const route = useRoute();

getPlaybackState();

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

async function play() {
    await put("spotify.play");
    is_playing.value = true;
}

async function pause() {
    await put("spotify.pause");
    is_playing.value = false;
}
</script>

<template>
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
    <div v-else-if="playback">
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
</template>
