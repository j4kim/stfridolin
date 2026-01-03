<script setup>
import { get } from "@/api";
import Button from "@/components/ui/button/Button.vue";
import Layout from "@/components/Layout.vue";
import { ref } from "vue";
import Tracks from "@/components/Tracks.vue";

const tracks = ref([]);

const loading = ref(false);

async function load() {
    loading.value = true;
    tracks.value = await get("tracks.queue");
    loading.value = false;
}

load();
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">File d'attente</h2>

        <Tracks :tracks></Tracks>

        <p class="px-4" v-if="!loading && !tracks.length">
            La file d'attente est vide
        </p>

        <div class="my-4 px-4">
            <RouterLink :to="{ name: 'add-to-queue' }">
                <Button class="w-full" variant="outline">
                    Ajouter un morceau en file d'attente
                </Button>
            </RouterLink>
        </div>
    </Layout>
</template>
