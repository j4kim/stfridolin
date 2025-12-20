<script setup>
import Search from "@/spotify/Search.vue";
import SelectDevice from "@/spotify/SelectDevice.vue";
import PlaybackState from "@/spotify/PlaybackState.vue";
import Layout from "@/components/Layout.vue";
import { Button } from "@/components/ui/button";
import { Play } from "lucide-vue-next";
import { useSpotifyStore } from "@/stores/spotify";
import { put } from "@/api";

const spotify = useSpotifyStore();

async function playTrack(uri) {
    const data = await put("spotify.play-track", uri);
    setTimeout(async () => await spotify.getPlaybackState(), 500);
}
</script>

<template>
    <Layout>
        <div class="flex flex-col gap-8 p-4">
            <div>
                <h2 class="mb-2 text-lg font-bold">Devices</h2>
                <SelectDevice />
            </div>

            <div class="max-w-sm">
                <h2 class="mb-2 text-lg font-bold">Playback state</h2>
                <PlaybackState />
            </div>

            <div class="max-w-sm">
                <h2 class="mb-2 text-lg font-bold">Search</h2>
                <Search>
                    <template #actions="{ track }">
                        <Button
                            variant="ghost"
                            size="icon"
                            class="rounded-full"
                            @click="playTrack(track.uri)"
                        >
                            <Play />
                        </Button>
                    </template>
                </Search>
            </div>
        </div>
    </Layout>
</template>
