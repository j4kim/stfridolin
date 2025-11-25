<script setup>
import { ref } from "vue";
import { get } from "../api";
import { route as ziggy } from "../../vendor/tightenco/ziggy";
import { useRoute } from "vue-router";

const error = ref(null);

const route = useRoute();

get("spotify.playback-state")
    .then((data) => console.log(data))
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
</template>
