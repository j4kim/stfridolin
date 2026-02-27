<script setup>
import { useGamesStore } from "@/stores/games";
import { onMounted, onUnmounted } from "vue";

const gamesStore = useGamesStore();

onMounted(() => (gamesStore.gameName = "marble-race"));
onUnmounted(() => (gamesStore.gameName = null));
</script>

<template>
    <RouterView></RouterView>
</template>
