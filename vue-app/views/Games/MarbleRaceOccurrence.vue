<script setup>
import Layout from "@/components/Layout.vue";
import { useGamesStore } from "@/stores/games";
import { ChevronRight } from "lucide-vue-next";
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const gamesStore = useGamesStore();

gamesStore.fetchGamesIfNeeded();

const occurrence = computed(() =>
    gamesStore.marbleRace?.occurrences.find((o) => o.id == route.params.occId),
);
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">
            <RouterLink :to="{ name: 'marble-races' }"
                >Courses de billes</RouterLink
            >
            <ChevronRight :size="14" class="mb-px inline" />
            <span class="font-bold">{{ occurrence?.title }}</span>
        </h2>
    </Layout>
</template>
