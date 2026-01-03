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
import Button from "@/components/ui/button/Button.vue";
import Tracks from "@/components/Tracks.vue";

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
    <div>
        <div class="mb-4 px-4">
            <InputGroup>
                <InputGroupInput
                    placeholder="Rechercher un morceau"
                    v-model="searchQuery"
                />
                <InputGroupAddon>
                    <Search />
                </InputGroupAddon>
            </InputGroup>
        </div>

        <Tracks :tracks="searchResults?.items">
            <template #actions="{ track }">
                <slot :track="track" name="actions"></slot>
            </template>
            <template #after>
                <div class="my-4 px-4">
                    <Button variant="ghost" class="w-full" @click="searchMore">
                        Charger plus
                    </Button>
                </div>
            </template>
        </Tracks>
    </div>
</template>
