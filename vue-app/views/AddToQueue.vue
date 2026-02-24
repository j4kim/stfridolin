<script setup>
import Layout from "@/components/Layout.vue";
import { Button } from "@/components/ui/button";
import ValidationDrawer from "@/components/ValidationDrawer.vue";
import Search from "@/spotify/Search.vue";
import { toast } from "vue-sonner";
import { ArrowLeft } from "lucide-vue-next";
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
        <div class="mt-2 ml-2">
            <RouterLink :to="{ name: 'vote' }">
                <Button size="sm" variant="ghost">
                    <ArrowLeft />
                    Combat en cours
                </Button>
            </RouterLink>
        </div>
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
                    :disabled="tracksStore.inQueue(track)"
                ></ValidationDrawer>
            </template>
        </Search>
    </Layout>
</template>
