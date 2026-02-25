<script setup>
import Layout from "@/components/Layout.vue";
import MarbleRaceComptetitorItem from "@/components/MarbleRaceComptetitorItem.vue";
import { ItemGroup, ItemSeparator } from "@/components/ui/item";
import { useGamesStore } from "@/stores/games";
import { useGuestStore } from "@/stores/guest";
import { ChevronRight } from "lucide-vue-next";
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const gamesStore = useGamesStore();
const guestStore = useGuestStore();

gamesStore.fetchGamesIfNeeded();

const occurrence = computed(() =>
    gamesStore.marbleRace?.occurrences.find((o) => o.id == route.params.occId),
);

const existingBet = computed(() => {
    return guestStore.movements.find(
        (m) => m.occurrence_id === occurrence.value?.id,
    );
});
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">
            <RouterLink :to="{ name: 'marble-races' }"
                >Courses de billes</RouterLink
            >
            <ChevronRight :size="14" class="mb-px inline" />
            <span class="font-bold">{{ occurrence?.title }}</span>
        </h2>

        <ItemGroup v-if="occurrence?.competitors?.length">
            <ItemSeparator />
            <template
                v-for="competitor in occurrence.competitors"
                :key="competitor.id"
            >
                <MarbleRaceComptetitorItem :competitor :existingBet />
                <ItemSeparator />
            </template>
            <slot name="after"></slot>
        </ItemGroup>
    </Layout>
</template>
