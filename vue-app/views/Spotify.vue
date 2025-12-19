<script setup>
import { get, put } from "@/api";
import { route as ziggy } from "@/../vendor/tightenco/ziggy";
import { useRoute } from "vue-router";
import Search from "@/spotify/Search.vue";
import { useSpotifyStore } from "@/stores/spotify";
import Progress from "@/components/ui/progress/Progress.vue";
import SelectDevice from "@/spotify/SelectDevice.vue";

const spotify = useSpotifyStore();
spotify.getPlaybackState();

const route = useRoute();

async function play(params = null) {
    await put("spotify.play", params);
    spotify.playback.is_playing = true;
}

async function pause() {
    await put("spotify.pause");
    spotify.playback.is_playing = false;
}
</script>

<template>
    <div class="flex flex-col gap-8">
        <div v-if="spotify.error">
            <p
                v-if="
                    spotify.error === 'App\\Exceptions\\NoSpotifyTokenException'
                "
            >
                No Spotify Token.
                <a
                    :href="ziggy('spotify-login', { intended: route.path })"
                    class="link-primary"
                >
                    Login to Spotify
                </a>
            </p>
            <p
                v-if="
                    spotify.error ===
                    'App\\Exceptions\\NoSpotifyPlaybackException'
                "
            >
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

        <div>
            Devices:
            <SelectDevice />
        </div>

        <div class="flex max-w-sm items-center gap-2" v-if="spotify.track">
            <img :src="spotify.track.img_thumbnail_url" />
            <div class="flex w-full flex-col">
                {{ spotify.track.name }} - {{ spotify.track.artist_name }}
                <div class="flex items-center gap-2">
                    <Progress
                        :model-value="spotify.progressRatio * 100"
                    ></Progress>
                    <button v-if="spotify.track.is_playing" @click="pause">
                        ⏸️
                    </button>
                    <button v-else @click="play">▶️</button>
                </div>
            </div>
        </div>

        <Search />
    </div>
</template>
