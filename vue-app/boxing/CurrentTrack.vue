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
        <div class="card card-side card-md grow bg-black/40 backdrop-blur-md">
            <figure class="aspect-square h-[7.5vw]">
                <img v-if="spotify.track" :src="spotify.track.img_url" />
            </figure>
            <div class="card-body p-[1.8vw]">
                <p class="text-[1.4vw]" v-if="spotify.track">
                    <span class="font-bold">{{ spotify.track.name }}</span>
                    -
                    <span>{{ spotify.track.artist_name }}</span>
                </p>
                <progress
                    v-if="spotify.track"
                    class="progress h-[0.8vw]"
                    :value="spotify.progressRatio"
                ></progress>
            </div>
        </div>
    </div>
</template>
