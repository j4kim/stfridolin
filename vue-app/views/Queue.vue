<script setup>
import { api } from "@/api";
import Button from "@/components/ui/button/Button.vue";
import Layout from "@/components/Layout.vue";
import { computed, ref } from "vue";
import Tracks from "@/components/Tracks.vue";
import Badge from "@/components/ui/badge/Badge.vue";
import IfAuth from "@/components/IfAuth.vue";
import { ArrowLeft, ListPlus } from "lucide-vue-next";
import { useGuestStore } from "@/stores/guest";

const tracks = ref([]);

const loading = ref(false);

const guestStore = useGuestStore();

async function load() {
    loading.value = true;
    tracks.value = await api("tracks.queue").get();
    loading.value = false;
}

load();
const guestTracks = computed(() => tracks.value.filter((t) => t.proposed_by));
const backupTracks = computed(() => tracks.value.filter((t) => !t.proposed_by));
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
        <Tracks :tracks="guestTracks" />

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
            <Tracks :tracks="backupTracks" />
        </IfAuth>
    </Layout>
</template>
