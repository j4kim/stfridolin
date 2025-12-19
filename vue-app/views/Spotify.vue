<script setup>
import Search from "@/spotify/Search.vue";
import SelectDevice from "@/spotify/SelectDevice.vue";
import PlaybackState from "@/spotify/PlaybackState.vue";
</script>

<template>
    <div class="flex flex-col gap-8">
        <div>
            <h2 class="text-lg font-bold">Devices</h2>
            <SelectDevice />
        </div>

        <div>
            <h2 class="text-lg font-bold">Playback state</h2>
            <PlaybackState />
        </div>

        <div>
            <h2 class="text-lg font-bold">Search</h2>
            <Search />
        </div>
    </div>
</template>
