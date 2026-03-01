<script setup>
import Layout from "@/components/Layout.vue";
import RaceOccurenceItem from "@/components/RaceOccurenceItem.vue";
import { ItemGroup, ItemSeparator } from "@/components/ui/item";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { useGamesStore } from "@/stores/games";
import { computed } from "vue";

const gamesStore = useGamesStore();

const occurrences = computed(() => gamesStore.game?.occurrences || []);
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">{{ gamesStore.game?.title }}</h2>

        <ItemGroup v-if="occurrences.length">
            <ItemSeparator />
            <template v-for="occ in occurrences" :key="occ.id">
                <RaceOccurenceItem
                    :occ="occ"
                    :showBetsOpenAt="
                        gamesStore.game.type === 'race' &&
                        occ.status === 'initial'
                    "
                />
                <ItemSeparator />
            </template>
        </ItemGroup>
        <Spinner v-else-if="gamesStore.fetching" class="m-4"></Spinner>
    </Layout>
</template>
