<script setup>
import Layout from "@/components/Layout.vue";
import MarbleRaceOccurenceItem from "@/components/MarbleRaceOccurenceItem.vue";
import { ItemGroup, ItemSeparator } from "@/components/ui/item";
import { useGamesStore } from "@/stores/games";
import { computed } from "vue";

const gamesStore = useGamesStore();

gamesStore.fetchGames();

const occurrences = computed(
    () => gamesStore.byName["marble-race"]?.occurrences || [],
);
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">Course de billes</h2>

        <ItemGroup v-if="occurrences.length">
            <ItemSeparator />
            <template v-for="occ in occurrences" :key="occ.id">
                <MarbleRaceOccurenceItem :occ="occ" />
                <ItemSeparator />
            </template>
        </ItemGroup>
    </Layout>
</template>
