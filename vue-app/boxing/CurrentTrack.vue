<script setup>
import Progress from "@/components/ui/progress/Progress.vue";
import { useClockStore } from "@/stores/clock";
import { useSpotifyStore } from "@/stores/spotify";

const spotify = useSpotifyStore();
const clock = useClockStore();

spotify.getPlaybackState();
</script>

<template>
    <div class="flex items-center gap-[3cqw] px-[3cqw]">
        <div class="w-1/5 text-right text-[1.6cqw]">
            À l'écoute actuellement:
        </div>
        <div
            class="flex h-[7.5cqw] grow rounded-[0.7cqw] bg-black/40 backdrop-blur-md"
        >
            <img
                class="aspect-square rounded-s-[inherit]"
                v-if="spotify.track"
                :src="spotify.track.img_url"
            />
            <div
                class="flex w-full flex-col justify-center gap-[0.8cqw] px-[1.8cqw]"
            >
                <p class="text-[1.4cqw]" v-if="spotify.track">
                    <span class="font-bold">{{ spotify.track.name }}</span>
                    -
                    <span>{{ spotify.track.artist_name }}</span>
                </p>
                <Progress
                    v-if="spotify.track"
                    class="h-[0.8cqw]"
                    :model-value="clock.progress.percent"
                ></Progress>
            </div>
        </div>
    </div>
</template>
