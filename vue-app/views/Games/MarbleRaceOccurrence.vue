<script setup>
import Competitors from "@/components/Competitors.vue";
import IfAuth from "@/components/IfAuth.vue";
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

async function bet(competitor) {
    const result = await gamesStore.betOn(competitor, "bet-on-a-marble");
    toast.success(result.message);
}
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

        <template v-if="occurrence">
            <p
                class="text-muted-foreground my-2 px-4 text-sm"
                v-if="
                    occurrence.status === 'open' ||
                    occurrence.status === 'initial'
                "
            >
                Départ à {{ occurrence.start_at_time }}
            </p>
            <p
                class="text-muted-foreground my-2 px-4 text-sm"
                v-else-if="occurrence.status === 'started'"
            >
                En cours
            </p>
            <p
                class="text-muted-foreground my-2 px-4 text-sm"
                v-else-if="occurrence.status === 'ranked'"
            >
                Terminée
            </p>

            <Competitors
                :competitors="occurrence.competitors"
                :ranking="
                    occurrence.status === 'ranked' ? occurrence.ranking : null
                "
            >
                <template #actions="{ competitor }">
                    <ValidationDrawer
                        v-if="!existingBet && occurrence.status === 'open'"
                        trigger="Choisir"
                        :title="`Parier sur ${competitor.name}&nbsp;?`"
                        :action="() => bet(competitor)"
                        articleName="bet-on-a-marble"
                        :disabled="gamesStore.betting"
                    ></ValidationDrawer>
                    <Badge v-if="existingBet?.competitor_id === competitor.id">
                        Ton pari
                    </Badge>
                </template>
            </Competitors>

            <IfAuth>
                <div class="mb-12 flex flex-col gap-4 p-4">
                    <RouterLink
                        :to="{
                            name: 'marble-race-ranking',
                            params: { occId: occurrence.id },
                        }"
                        class=""
                        v-if="occurrence.status === 'started'"
                    >
                        <Button class="w-full">Faire classement</Button>
                    </RouterLink>
                    <Button
                        variant="link"
                        as="a"
                        :href="`/admin/occurrences/${occurrence.id}`"
                    >
                        Ouvrir sur la console admin
                    </Button>
                </div>
            </IfAuth>
        </template>
        <Spinner v-else-if="gamesStore.fetchingGames" class="m-4"></Spinner>
    </Layout>
</template>
