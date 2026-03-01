<script setup>
import Layout from "@/components/Layout.vue";
import { useGamesStore } from "@/stores/games";
import { ChevronRight } from "lucide-vue-next";
import { computed } from "vue";

const gamesStore = useGamesStore();

const occurrence = computed(() => gamesStore.game?.occurrences[0]);
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">
            <RouterLink :to="{ name: 'joes-weight' }">
                {{ gamesStore.game?.title }}
            </RouterLink>
            <ChevronRight :size="14" class="mb-px inline" />
            <span class="font-bold">Pesée</span>
        </h2>
    </Layout>
</template>
