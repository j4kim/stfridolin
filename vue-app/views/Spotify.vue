<script setup>
import Search from "@/spotify/Search.vue";
import SelectDevice from "@/spotify/SelectDevice.vue";
import PlaybackState from "@/spotify/PlaybackState.vue";
import Layout from "@/components/Layout.vue";
import { Button } from "@/components/ui/button";
import { Play } from "lucide-vue-next";
import { useSpotifyStore } from "@/stores/spotify";
import { useClientStore } from "@/stores/client";

const spotify = useSpotifyStore();
const client = useClientStore();
</script>

<template>
    <Layout>
        <div class="flex flex-col gap-8 p-4">
            <div>
                <h2 class="mb-2 text-lg font-bold">Master client</h2>
                <p class="mb-2">
                    The master client is the tab that is responsible of managing
                    the playback and the state of the fight.
                </p>
                <Button v-if="client.isMaster" size="sm" disabled>
                    This client is master
                </Button>
                <Button v-else @click="client.setAsMaster" size="sm">
                    Set this client as master
                </Button>
            </div>

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
                            @click="spotify.playTrack(track.spotify_uri)"
                        >
                            <Play />
                        </Button>
                    </template>
                </Search>
            </div>
        </div>
    </Layout>
</template>
