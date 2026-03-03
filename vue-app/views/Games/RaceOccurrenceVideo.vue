<script setup>
import Competitors from "@/components/Competitors.vue";
import Layout from "@/components/Layout.vue";
import Badge from "@/components/ui/badge/Badge.vue";
import Button from "@/components/ui/button/Button.vue";
import { useGamesStore } from "@/stores/games";
import { useFullscreen, useWakeLock } from "@vueuse/core";
import { ChevronRight } from "lucide-vue-next";
import { computed, onMounted, useTemplateRef } from "vue";
import { onBeforeRouteUpdate, useRoute } from "vue-router";

const route = useRoute();

const gamesStore = useGamesStore();

gamesStore.fetchOccurrence(route.params.occId);

const sortedCompetitors = computed(() => {
    if (gamesStore.occurrence?.ranking) {
        return gamesStore.occurrence.competitors
            .map((c) => {
                const rank = gamesStore.occurrence.ranking[c.id] ?? Infinity;
                return { ...c, rank };
            })
            .toSorted((a, b) => a.rank - b.rank);
    }
    return gamesStore.occurrence?.competitors ?? [];
});

onBeforeRouteUpdate((to) => {
    gamesStore.fetchOccurrence(to.params.occId);
});

const video = useTemplateRef("video");

const { enter } = useFullscreen(video);

const { request, isSupported } = useWakeLock();

onMounted(async () => {
    if (isSupported.value) {
        await request();
    }
});
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">
            <RouterLink :to="{ name: 'race-index' }">{{
                gamesStore.game?.title
            }}</RouterLink>
            <ChevronRight :size="14" class="mb-px inline" />
            <RouterLink :to="{ name: 'race-occurrence' }">{{
                gamesStore.occurrence?.title
            }}</RouterLink>
            <ChevronRight :size="14" class="mb-px inline" />
            <span class="font-bold">Intégration vidéo</span>
        </h2>

        <div class="p-4">
            <Button size="sm" @click="enter">Plein écran</Button>
        </div>

        <div class="flex h-dvh flex-col" ref="video">
            <h2 class="p-6 font-bold">
                {{ gamesStore.occurrence?.title }}
            </h2>

            <div class="grow"></div>

            <div class="flex flex-col items-start gap-4 p-6 text-black">
                <div
                    v-for="competitor in sortedCompetitors"
                    class="flex items-center gap-2 rounded-lg bg-white p-2"
                >
                    <div v-if="competitor.rank" class="w-10 text-center">
                        <span v-if="competitor.rank === Infinity"> DNF </span>
                        <Badge v-else class="w-9 text-xl">{{
                            competitor.rank
                        }}</Badge>
                    </div>

                    <img
                        v-if="competitor.image_url"
                        class="size-12 rounded"
                        :src="competitor.image_url"
                    />
                    <div v-else class="size-12 rounded bg-neutral-700"></div>

                    <div>
                        <div class="mr-8 text-xl font-bold">
                            {{ competitor.name }}
                        </div>
                        <div v-if="competitor.bettors.length">
                            {{ competitor.bettors.length }} paris
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
