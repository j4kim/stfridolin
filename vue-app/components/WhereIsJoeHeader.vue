<script setup>
import { api } from "@/api";
import ParticipateToWhereIsJoe from "./ParticipateToWhereIsJoe.vue";
import IfAuth from "./IfAuth.vue";
import ValidationDrawer from "./ValidationDrawer.vue";
import { useGamesStore } from "@/stores/games";

const gamesStore = useGamesStore();

const firstOcc = computed(() => gamesStore.game?.occurrences[0]);

async function start() {
    await api("occurrences.start")
        .params({ occurrence: firstOcc.value.id })
        .post();
}
</script>

<template>
    <div>
        <ParticipateToWhereIsJoe />

        <IfAuth v-if="firstOcc?.status === 'initial'">
            <ValidationDrawer
                trigger="Démarrer"
                :title="`Démarrer le jeu&nbsp;?`"
                :action="() => start()"
            />
        </IfAuth>
    </div>
</template>
