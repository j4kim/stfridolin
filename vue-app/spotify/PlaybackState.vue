<script setup>
import { route as ziggy } from "@/../vendor/tightenco/ziggy";
import { useSpotifyStore } from "@/stores/spotify";
import Player from "./Player.vue";
import { useRoute } from "vue-router";

const route = useRoute();

const spotify = useSpotifyStore();
spotify.getPlaybackState();
</script>

<template>
    <div>
        <Player v-if="spotify.playback" />
        <div v-else-if="spotify.playbackError">
            <p
                v-if="
                    spotify.playbackError ===
                    'App\\Exceptions\\NoSpotifyTokenException'
                "
            >
                No Spotify Token.
                <a
                    class="link"
                    :href="ziggy('spotify-login', { intended: route.path })"
                >
                    Login to Spotify
                </a>
            </p>
            <p
                v-if="
                    spotify.playbackError ===
                    'App\\Exceptions\\NoSpotifyPlaybackException'
                "
            >
                No spotify playback.
                <a class="link" href="https://open.spotify.com" target="_blank">
                    Open Spotify and play a track
                </a>
            </p>
        </div>
    </div>
</template>
