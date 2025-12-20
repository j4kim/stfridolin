<script setup>
import { ref } from "vue";
import { get } from "@/api";
import { watchDebounced } from "@vueuse/core";
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from "@/components/ui/input-group";
import { Search } from "lucide-vue-next";
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

const searchQuery = ref("");
watchDebounced(searchQuery, searchTracks, { debounce: 500 });

const searchResults = ref(null);

async function searchTracks() {
    searchResults.value = await get("spotify.search-tracks", {
        q: searchQuery.value,
    });
}

async function searchMore() {
    const data = await get("spotify.search-tracks", {
        q: searchQuery.value,
        offset: searchResults.value.offset + 10,
    });
    searchResults.value = {
        ...data,
        items: searchResults.value.items.concat(data.items),
    };
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

    <ItemGroup v-if="searchResults">
        <template v-for="(track, index) in searchResults.items" :key="track.id">
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
                    <slot :track="track" name="actions"></slot>
                </ItemActions>
            </Item>
            <ItemSeparator v-if="index !== track.length - 1" />
        </template>
        <Button variant="ghost" class="my-4" @click="searchMore">
            Charger plus
        </Button>
    </ItemGroup>
</template>
