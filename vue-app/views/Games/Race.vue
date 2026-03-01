<script setup>
import { useGamesStore } from "@/stores/games";
import { onUnmounted } from "vue";
import { useRoute } from "vue-router";

const gamesStore = useGamesStore();

const route = useRoute();

gamesStore.gameName = route.params.gameName;

onUnmounted(() => (gamesStore.gameName = null));
</script>

<template>
    <RouterView></RouterView>
</template>
