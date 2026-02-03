<script setup>
import { api } from "@/api";
import { useFightStore } from "@/stores/fight";
import Button from "@/components/ui/button/Button.vue";
import ValidationDrawer from "@/components/ValidationDrawer.vue";
import Layout from "@/components/Layout.vue";
import Tracks from "@/components/Tracks.vue";
import { Alert, AlertDescription } from "@/components/ui/alert";
import { TriangleAlert } from "lucide-vue-next";

const fightStore = useFightStore();

fightStore.fetchCurrentFight();

async function vote(track) {
    return await api("votes.vote")
        .params([fightStore.fight.id, track.id])
        .post();
}
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">
            Combat en cours
            <span class="opacity-50" v-if="fightStore.isEnded">
                (terminé)
            </span>
        </h2>

        <Tracks
            v-if="fightStore.fight"
            :tracks="[
                fightStore.fight.left_track,
                fightStore.fight.right_track,
            ]"
        >
            <template #actions="{ track }">
                <ValidationDrawer
                    trigger="Voter"
                    :title="`Voter pour ${track.name}&nbsp;?`"
                    :action="() => vote(track)"
                    articleName="vote"
                    :disabled="fightStore.isEnded"
                ></ValidationDrawer>
            </template>
        </Tracks>
        <div v-else-if="fightStore.error" class="my-4 px-4">
            <Alert>
                <TriangleAlert />
                <AlertDescription>
                    {{ fightStore.error }}
                </AlertDescription>
            </Alert>
        </div>

        <div class="my-4 px-4">
            <RouterLink :to="{ name: 'add-to-queue' }">
                <Button class="w-full" variant="outline">
                    Ajouter un morceau en file d'attente
                </Button>
            </RouterLink>
        </div>
    </Layout>
</template>
