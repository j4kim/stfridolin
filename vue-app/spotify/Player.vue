<script setup>
import { put } from "@/api";
import Button from "@/components/ui/button/Button.vue";
import Progress from "@/components/ui/progress/Progress.vue";
import { useClockStore } from "@/stores/clock";
import { useSpotifyStore } from "@/stores/spotify";
import { Pause, Play } from "lucide-vue-next";

const spotify = useSpotifyStore();
const clock = useClockStore();

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
    <div class="flex w-full items-center gap-2" v-if="spotify.track">
        <img :src="spotify.track.img_thumbnail_url" />
        <div class="flex grow flex-col">
            {{ spotify.track.name }} - {{ spotify.track.artist_name }}
            <div class="flex items-center gap-2">
                <Progress :model-value="clock.progress.percent"></Progress>
                <Button
                    variant="outline"
                    size="icon"
                    class="rounded-full"
                    @click="spotify.isPlaying ? pause() : play()"
                >
                    <component :is="spotify.isPlaying ? Pause : Play" />
                </Button>
            </div>
        </div>
    </div>
</template>
