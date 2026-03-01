<script setup>
import { useGamesStore } from "@/stores/games";
import { onBeforeRouteLeave, onBeforeRouteUpdate, useRoute } from "vue-router";

const gamesStore = useGamesStore();

const route = useRoute();

function setGame(route) {
    const gameName = route.params.gameName;
    if (gameName) {
        gamesStore.gameName = route.params.gameName;
        gamesStore.fetchGame();
    } else {
        gamesStore.gameName = null;
        gamesStore.game = null;
    }
}

setGame(route);
onBeforeRouteUpdate(setGame);
onBeforeRouteLeave(setGame);
</script>

<template>
    <RouterView></RouterView>
</template>
