<script setup>
import Layout from "@/components/Layout.vue";
import ValidationDrawer from "@/components/ValidationDrawer.vue";
import Search from "@/spotify/Search.vue";
import { toast } from "vue-sonner";
import { ChevronRight } from "lucide-vue-next";
import { useRouter } from "vue-router";
import { useTracksStore } from "@/stores/tracks";

const router = useRouter();

const tracksStore = useTracksStore();

async function add(track) {
    const response = await tracksStore.add(track);
    toast.success(response.message, {
        action: {
            label: "Voir la file",
            onClick: () => router.push({ name: "queue" }),
        },
    });
}
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">
            <RouterLink :to="{ name: 'vote' }">Jukeboxe</RouterLink>
            <ChevronRight :size="14" class="mb-px inline" />
            <span class="font-bold">Ajouter un morceau</span>
        </h2>
        <Search>
            <template #actions="{ track }">
                <ValidationDrawer
                    trigger="Ajouter"
                    :title="`Ajouter ${track.name} à la file d'attente&nbsp;?`"
                    :action="() => add(track)"
                    articleName="add-to-queue"
                    :disabled="tracksStore.inQueue(track)"
                ></ValidationDrawer>
            </template>
        </Search>
    </Layout>
</template>
