<script setup>
import { useMainStore } from "../stores/main";

const mainStore = useMainStore();

window.onSpotifyWebPlaybackSDKReady = () => {
    console.log("onSpotifyWebPlaybackSDKReady");

    if (!mainStore.spotifyToken?.access_token) {
        console.warn("No Spotify access token");
        return;
    }

    const player = new Spotify.Player({
        name: "Web Playback SDK Quick Start Player",
        getOAuthToken: (cb) => {
            cb(mainStore.spotifyToken?.access_token);
        },
        volume: 0.5,
    });

    player.addListener("ready", ({ device_id }) => {
        console.log("Ready with Device ID", device_id);
    });

    player.addListener("not_ready", ({ device_id }) => {
        console.log("Device ID has gone offline", device_id);
    });

    player.addListener("initialization_error", ({ message }) => {
        console.error(message);
    });

    player.addListener("authentication_error", ({ message }) => {
        console.error(message);
    });

    player.addListener("account_error", ({ message }) => {
        console.error(message);
    });

    player.connect();
};
</script>

<template>
    <div></div>
</template>
