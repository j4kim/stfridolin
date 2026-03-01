<script setup>
import { useGamesStore } from "@/stores/games";
import { onUnmounted } from "vue";

const gamesStore = useGamesStore();

gamesStore.gameName = "joes-weight";

onUnmounted(() => (gamesStore.gameName = null));

gamesStore.fetchGame();
</script>

<template>
    <RouterView></RouterView>
</template>
