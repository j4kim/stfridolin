<script setup>
import { ref } from "vue";
import { get, put } from "@/api";
import SearchIcon from "@/icons/SearchIcon.vue";
import { watchDebounced } from "@vueuse/core";
import PlayIcon from "@/icons/PlayIcon.vue";
import { useSpotifyStore } from "@/stores/spotify";

const spotify = useSpotifyStore();

const tracks = ref([]);
const searchQuery = ref("");
watchDebounced(searchQuery, searchTracks, { debounce: 500 });

async function searchTracks() {
    const data = await get("spotify.search-tracks", { q: searchQuery.value });
    tracks.value = data.items;
}

async function playTrack(uri) {
    const data = await put("spotify.play-track", uri);
    setTimeout(async () => await spotify.getPlaybackState(), 500);
}
</script>

<template>
    <div>
        <label class="flex">
            <SearchIcon />
            <input
                type="search"
                placeholder="Search track"
                v-model="searchQuery"
            />
        </label>
    </div>

    <ul
        class="list bg-base-100 rounded-box max-w-lg shadow-md"
        v-if="tracks.length"
    >
        <li v-for="track in tracks" class="list-row">
            <div>
                <img
                    class="rounded-box size-10"
                    :src="track.album.images[2].url"
                />
            </div>
            <div>
                <div>{{ track.name }}</div>
                <div class="text-xs font-semibold opacity-60">
                    {{ track.artists.map((a) => a.name).join(", ") }}
                </div>
            </div>
            <button
                class="btn btn-square btn-ghost"
                @click="playTrack(track.uri)"
            >
                <PlayIcon />
            </button>
        </li>
    </ul>
</template>
