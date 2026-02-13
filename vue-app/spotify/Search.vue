<script setup>
import { ref } from "vue";
import { api } from "@/api";
import { watchDebounced } from "@vueuse/core";
import {
    InputGroup,
    InputGroupAddon,
    InputGroupButton,
    InputGroupInput,
} from "@/components/ui/input-group";
import { Search, X } from "lucide-vue-next";
import Button from "@/components/ui/button/Button.vue";
import Tracks from "@/components/Tracks.vue";
import { useRoute, useRouter } from "vue-router";

const router = useRouter();
const route = useRoute();

const searchQuery = ref(route.query.q);

const searchResults = ref(null);

watchDebounced(searchQuery, searchTracks, { debounce: 500 });

if (searchQuery.value) {
    searchTracks();
}

async function searchTracks() {
    const params = { q: searchQuery.value };
    router.replace({ query: params });
    searchResults.value = await api("spotify.search-tracks")
        .params(params)
        .get();
}

async function searchMore() {
    const data = await api("spotify.search-tracks")
        .params({
            q: searchQuery.value,
            offset: searchResults.value.offset + 10,
        })
        .get();
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
                <InputGroupAddon align="inline-end">
                    <InputGroupButton
                        class="rounded-full"
                        @click="searchQuery = ''"
                    >
                        <X />
                    </InputGroupButton>
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
