<script setup>
import Button from "@/components/ui/button/Button.vue";
import Layout from "@/components/Layout.vue";
import Tracks from "@/components/Tracks.vue";
import IfAuth from "@/components/IfAuth.vue";
import { ChevronRight, ListPlus } from "lucide-vue-next";
import { useTracksStore } from "@/stores/tracks";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { computed } from "vue";
import { useMainStore } from "@/stores/main";

const tracksStore = useTracksStore();
const mainStore = useMainStore();

tracksStore.fetchQueue();



const guestTracksEndTimeEstimate = computed(() =>{
    return new Date(Date.now() + tracksStore.guestTracksTimeEstimateMs)
})



</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">
            <RouterLink :to="{ name: 'vote' }">Jukeboxe</RouterLink>
            <ChevronRight :size="14" class="mb-px inline" />
            <span class="font-bold">File d'attente</span>
        </h2>

        <IfAuth>
            <p class="my-2 px-4">Morceaux ajoutés par les invités. Heure estimée de fin : {{ guestTracksEndTimeEstimate.toLocaleTimeString() }}</p>
        </IfAuth>
        <Spinner v-if="tracksStore.fetchingQueue" class="m-4" />
        <Tracks :tracks="tracksStore.guestTracks" />

        <div class="my-4 px-4">
            <RouterLink :to="{ name: 'add-to-queue' }" v-if="mainStore.isJukeboxActive">
                <Button class="w-full" variant="outline">
                    <ListPlus />
                    Ajouter un morceau en file d'attente
                </Button>
            </RouterLink>
            <Button class="w-full" variant="outline" v-else>
                <ListPlus />
                <s>Ajouter un morceau en file d'attente</s> Le Jukeboxe ferme !
            </Button>
        </div>

        <IfAuth>
            <p class="my-2 mt-8 px-4">Morceaux en réserve:</p>
            <Tracks :tracks="tracksStore.backupTracks" />
        </IfAuth>
    </Layout>
</template>
