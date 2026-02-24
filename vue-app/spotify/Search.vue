<script setup>
import {
    InputGroup,
    InputGroupAddon,
    InputGroupButton,
    InputGroupInput,
} from "@/components/ui/input-group";
import { Search, X } from "lucide-vue-next";
import Button from "@/components/ui/button/Button.vue";
import Tracks from "@/components/Tracks.vue";
import { useTracksStore } from "@/stores/tracks";
import Spinner from "@/components/ui/spinner/Spinner.vue";

const tracksStore = useTracksStore();
</script>

<template>
    <div>
        <div class="mb-4 px-4">
            <InputGroup>
                <InputGroupInput
                    placeholder="Rechercher un morceau"
                    v-model="tracksStore.searchQuery"
                />
                <InputGroupAddon>
                    <Search />
                </InputGroupAddon>
                <InputGroupAddon align="inline-end">
                    <InputGroupButton
                        class="rounded-full"
                        @click="tracksStore.searchQuery = ''"
                    >
                        <X />
                    </InputGroupButton>
                </InputGroupAddon>
            </InputGroup>
        </div>

        <Spinner v-if="tracksStore.searching" class="m-4" />

        <Tracks :tracks="tracksStore.searchResults?.items">
            <template #actions="{ track }">
                <slot :track="track" name="actions"></slot>
            </template>
            <template #after>
                <div class="my-4 px-4">
                    <Button
                        variant="ghost"
                        class="w-full"
                        @click="tracksStore.searchMore"
                        :disabled="tracksStore.searchingMore"
                    >
                        <Spinner v-if="tracksStore.searchingMore" />
                        Charger plus
                    </Button>
                </div>
            </template>
        </Tracks>
    </div>
</template>
