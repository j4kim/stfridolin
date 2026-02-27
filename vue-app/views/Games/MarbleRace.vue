<script setup>
import { useGamesStore } from "@/stores/games";
import { onUnmounted } from "vue";

const gamesStore = useGamesStore();

gamesStore.gameName = "marble-race";

onUnmounted(() => (gamesStore.gameName = null));
</script>

<template>
    <RouterView></RouterView>
</template>
