<script setup>
import { api } from "@/api";
import ParticipateToWhereIsJoe from "./ParticipateToWhereIsJoe.vue";
import IfAuth from "./IfAuth.vue";
import ValidationDrawer from "./ValidationDrawer.vue";
import { useGamesStore } from "@/stores/games";

const gamesStore = useGamesStore();

async function startAll() {
    await api("occurrences.startAll")
        .params({ gameId: gamesStore.gameId })
        .post();
}
</script>

<template>
    <div>
        <ParticipateToWhereIsJoe />

        <IfAuth v-if="gamesStore.game?.occurrences[0]?.status === 'initial'">
            <ValidationDrawer
                trigger="Démarrer"
                :title="`Démarrer le jeu&nbsp;?`"
                :action="() => startAll()"
            />
        </IfAuth>
    </div>
</template>
