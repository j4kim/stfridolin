<script setup>
import Layout from "@/components/Layout.vue";
import MarbleRaceOccurenceItem from "@/components/MarbleRaceOccurenceItem.vue";
import { ItemGroup, ItemSeparator } from "@/components/ui/item";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { useGamesStore } from "@/stores/games";
import { tr } from "@/translate";
import { computed } from "vue";

const gamesStore = useGamesStore();

gamesStore.fetchGame();

const occurrences = computed(() => gamesStore.game?.occurrences || []);
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">{{ tr($route.params.gameName) }}</h2>

        <ItemGroup v-if="occurrences.length">
            <ItemSeparator />
            <template v-for="occ in occurrences" :key="occ.id">
                <MarbleRaceOccurenceItem :occ="occ" />
                <ItemSeparator />
            </template>
        </ItemGroup>
        <Spinner v-else-if="gamesStore.fetching" class="m-4"></Spinner>
    </Layout>
</template>
