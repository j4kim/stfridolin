<script setup>
import { useSpotifyStore } from "../stores/spotify";

const spotify = useSpotifyStore();

spotify.getPlaybackState();
</script>

<template>
    <div class="flex items-center gap-[3vw] px-[3vw]">
        <div class="w-1/5 text-right text-[1.6vw]">
            À l'écoute actuellement:
        </div>
        <div
            class="card card-side card-md w-4/5 bg-black/60"
            v-if="spotify.track"
        >
            <figure>
                <img
                    :src="spotify.track.img_url"
                    class="aspect-square h-[7.5vw]"
                />
            </figure>
            <div class="card-body p-[1.8vw]">
                <p class="text-[1.4vw]">
                    <span class="font-bold">{{ spotify.track.name }}</span>
                    -
                    <span>{{ spotify.track.artist_name }}</span>
                </p>
                <progress
                    class="progress h-[0.8vw]"
                    :value="spotify.track.progress"
                ></progress>
            </div>
        </div>
    </div>
</template>
