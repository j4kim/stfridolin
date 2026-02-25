<script setup>
import Competitors from "@/components/Competitors.vue";
import Layout from "@/components/Layout.vue";
import Badge from "@/components/ui/badge/Badge.vue";
import Button from "@/components/ui/button/Button.vue";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import ValidationDrawer from "@/components/ValidationDrawer.vue";
import { useGamesStore } from "@/stores/games";
import { useGuestStore } from "@/stores/guest";
import { ChevronRight } from "lucide-vue-next";
import { computed } from "vue";
import { useRoute } from "vue-router";
import { toast } from "vue-sonner";

const route = useRoute();

const gamesStore = useGamesStore();

gamesStore.fetchGamesIfNeeded();

const occurrence = computed(() =>
    gamesStore.marbleRace?.occurrences.find((o) => o.id == route.params.occId),
);
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">
            <RouterLink :to="{ name: 'marble-races' }"
                >Courses de billes</RouterLink
            >
            <ChevronRight :size="14" class="mb-px inline" />
            <RouterLink
                :to="{
                    name: 'marble-race-occurrence',
                    params: { occId: occurrence?.id },
                }"
                >{{ occurrence?.title }}</RouterLink
            >
            <ChevronRight :size="14" class="mb-px inline" />
            <span class="font-bold">Classement</span>
        </h2>

        <template v-if="occurrence">
            <Competitors :competitors="occurrence.competitors">
                <template #actions="{ competitor }"> </template>
            </Competitors>
        </template>
        <Spinner v-else-if="gamesStore.fetchingGames" class="m-4"></Spinner>
    </Layout>
</template>
