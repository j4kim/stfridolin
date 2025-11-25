<script setup>
import { ref } from "vue";
import { get } from "../api";
import { route as ziggy } from "../../vendor/tightenco/ziggy";
import { useRoute } from "vue-router";

const error = ref(null);
const playback = ref(null);

const route = useRoute();

get("spotify.playback-state")
    .then((data) => (playback.value = data))
    .catch((e) => {
        if (e.response?.data?.exception) {
            error.value = e.response.data.exception;
        } else {
            alert(error.response?.data?.message ?? error.message);
        }
    });
</script>

<template>
    <div v-if="error">
        <p v-if="error === 'App\\Exceptions\\NoSpotifyTokenException'">
            No Spotify Token.
            <a :href="ziggy('spotify-login', { intended: route.path })">
                Login to Spotify
            </a>
        </p>
        <p v-if="error === 'App\\Exceptions\\NoSpotifyPlaybackException'">
            No spotify playback.
            <a href="https://open.spotify.com" target="_blank">Open Spotify</a>
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
        <button v-if="playback.is_playing">⏸️</button>
        <button v-else>▶️</button>
    </div>
</template>
