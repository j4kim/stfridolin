<script setup>
import { api } from "@/api";
import Button from "@/components/ui/button/Button.vue";
import Layout from "@/components/Layout.vue";
import { computed, ref } from "vue";
import Tracks from "@/components/Tracks.vue";
import Badge from "@/components/ui/badge/Badge.vue";
import IfAuth from "@/components/IfAuth.vue";

const tracks = ref([]);

const loading = ref(false);

async function load() {
    loading.value = true;
    tracks.value = await api("tracks.queue").get();
    tracks.value.slice(0, 2).map((t) => (t.isNext = true));
    loading.value = false;
}

load();

const guestTracks = computed(() => tracks.value.filter((t) => t.priority == 1));
const backupTracks = computed(() =>
    tracks.value.filter((t) => t.priority == 0),
);
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">File d'attente</h2>

        <IfAuth>
            <p class="my-2 px-4">Morceaux ajoutés par les invités:</p>
        </IfAuth>
        <Tracks :tracks="guestTracks">
            <template #actions="{ track }">
                <Badge v-if="track.isNext" variant="secondary">
                    prochain combat
                </Badge>
            </template>
        </Tracks>

        <div class="my-4 px-4">
            <RouterLink :to="{ name: 'add-to-queue' }">
                <Button class="w-full" variant="outline">
                    Ajouter un morceau en file d'attente
                </Button>
            </RouterLink>
        </div>

        <IfAuth>
            <p class="my-2 mt-8 px-4">Morceaux en réserve:</p>
            <Tracks :tracks="backupTracks">
                <template #actions="{ track }">
                    <Badge v-if="track.isNext" variant="secondary">
                        prochain combat
                    </Badge>
                </template>
            </Tracks>
        </IfAuth>
    </Layout>
</template>
