<script setup>
import { api } from "@/api";
import Layout from "@/components/Layout.vue";
import ValidationDrawer from "@/components/ValidationDrawer.vue";
import Search from "@/spotify/Search.vue";
import { toast } from "vue-sonner";

async function add(track) {
    const response = await api("tracks.store").params(track.spotify_uri).post();
    toast.success(response.message);
}
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">
            Ajouter un morceau à la file d'attente
        </h2>
        <Search>
            <template #actions="{ track }">
                <ValidationDrawer
                    trigger="Ajouter"
                    :title="`Ajouter ${track.name} à la file d'attente&nbsp;?`"
                    :action="() => add(track)"
                    articleName="add-to-queue"
                ></ValidationDrawer>
            </template>
        </Search>
    </Layout>
</template>
