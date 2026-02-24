<script setup>
import Button from "@/components/ui/button/Button.vue";
import Layout from "@/components/Layout.vue";
import Tracks from "@/components/Tracks.vue";
import IfAuth from "@/components/IfAuth.vue";
import { ArrowLeft, ListPlus } from "lucide-vue-next";
import { useTracksStore } from "@/stores/tracks";
import Spinner from "@/components/ui/spinner/Spinner.vue";

const tracksStore = useTracksStore();

tracksStore.fetchQueue();
</script>

<template>
    <Layout>
        <div class="mt-2 ml-2">
            <RouterLink :to="{ name: 'vote' }">
                <Button size="sm" variant="ghost">
                    <ArrowLeft />
                    Combat en cours
                </Button>
            </RouterLink>
        </div>

        <h2 class="my-2 px-4 font-bold">File d'attente</h2>

        <IfAuth>
            <p class="my-2 px-4">Morceaux ajoutés par les invités:</p>
        </IfAuth>
        <Spinner v-if="tracksStore.fetchingQueue" class="m-4" />
        <Tracks :tracks="tracksStore.guestTracks" />

        <div class="my-4 px-4">
            <RouterLink :to="{ name: 'add-to-queue' }">
                <Button class="w-full" variant="outline">
                    <ListPlus />
                    Ajouter un morceau en file d'attente
                </Button>
            </RouterLink>
        </div>

        <IfAuth>
            <p class="my-2 mt-8 px-4">Morceaux en réserve:</p>
            <Tracks :tracks="tracksStore.backupTracks" />
        </IfAuth>
    </Layout>
</template>
