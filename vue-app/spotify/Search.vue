<script setup>
import { ref } from "vue";
import { get, put } from "@/api";
import { watchDebounced } from "@vueuse/core";
import { useSpotifyStore } from "@/stores/spotify";
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from "@/components/ui/input-group";
import { Play, Search } from "lucide-vue-next";
import {
    ItemGroup,
    Item,
    ItemMedia,
    ItemContent,
    ItemTitle,
    ItemDescription,
    ItemActions,
    ItemSeparator,
} from "@/components/ui/item";
import Button from "@/components/ui/button/Button.vue";

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
    <InputGroup>
        <InputGroupInput
            placeholder="Rechercher un morceau"
            v-model="searchQuery"
        />
        <InputGroupAddon>
            <Search />
        </InputGroupAddon>
    </InputGroup>

    <ItemGroup>
        <template v-for="(track, index) in tracks" :key="track.id">
            <Item>
                <ItemMedia>
                    <img
                        class="rounded-box size-10"
                        :src="track.album.images[2].url"
                    />
                </ItemMedia>
                <ItemContent class="gap-1">
                    <ItemTitle>{{ track.name }}</ItemTitle>
                    <ItemDescription>
                        {{ track.artists.map((a) => a.name).join(", ") }}
                    </ItemDescription>
                </ItemContent>
                <ItemActions>
                    <Button
                        variant="ghost"
                        size="icon"
                        class="rounded-full"
                        @click="playTrack(track.uri)"
                    >
                        <Play />
                    </Button>
                </ItemActions>
            </Item>
            <ItemSeparator v-if="index !== track.length - 1" />
        </template>
    </ItemGroup>
</template>
