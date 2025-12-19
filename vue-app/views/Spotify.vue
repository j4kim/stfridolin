<script setup>
import Search from "@/spotify/Search.vue";
import SelectDevice from "@/spotify/SelectDevice.vue";
import PlaybackState from "@/spotify/PlaybackState.vue";
import Layout from "@/components/Layout.vue";
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
                <Search />
            </div>
        </div>
    </Layout>
</template>
