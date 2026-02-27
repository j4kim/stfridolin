<script setup>
import { api } from "@/api";
import { useFightStore } from "@/stores/fight";
import Button from "@/components/ui/button/Button.vue";
import ValidationDrawer from "@/components/ValidationDrawer.vue";
import Layout from "@/components/Layout.vue";
import Tracks from "@/components/Tracks.vue";
import { Alert, AlertDescription } from "@/components/ui/alert";
import {
    ChevronRight,
    ListMusic,
    ListPlus,
    TriangleAlert,
} from "lucide-vue-next";
import { toast } from "vue-sonner";
import { ref } from "vue";
import Spinner from "@/components/ui/spinner/Spinner.vue";

const fightStore = useFightStore();

const loading = ref(true);

fightStore.fetchCurrentFight().finally(() => (loading.value = false));

async function vote(track) {
    const response = await api("votes.vote")
        .params([fightStore.fight.id, track.id])
        .post();
    toast.success(response.message);
}
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">
            <span>Jukeboxe</span>
            <ChevronRight :size="14" class="mb-px inline" />
            <span class="font-bold"
                >Combat en cours
                <span class="opacity-50" v-if="fightStore.isEnded">
                    (terminé)
                </span>
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
        <Spinner v-else-if="loading" class="m-4"></Spinner>

        <div class="my-4 flex flex-col gap-2 px-4">
            <RouterLink :to="{ name: 'add-to-queue' }">
                <Button class="w-full" variant="outline">
                    <ListPlus />
                    Ajouter un morceau en file d'attente
                </Button>
            </RouterLink>
            <RouterLink :to="{ name: 'queue' }">
                <Button class="w-full" variant="outline">
                    <ListMusic />
                    Voir la file d'attente
                </Button>
            </RouterLink>
        </div>
    </Layout>
</template>
