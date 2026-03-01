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

gamesStore.fetchOccurrence(route.params.occId);

const status = computed(() => gamesStore.occurrence?.status);

const existingBet = computed(() => {
    return guestStore.movements.find(
        (m) => m.occurrence_id === gamesStore.occurrence?.id,
    );
});

async function bet(competitor) {
    const result = await gamesStore.betOn(competitor, "bet-on-a-marble");
    toast.success(result.message);
}

async function open() {
    const result = await gamesStore.openRace();
    toast.success(result.message);
}

async function start() {
    const result = await gamesStore.startRace();
    toast.success(result.message);
}
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">
            <RouterLink :to="{ name: 'race-index' }"
                >Courses de billes</RouterLink
            >
            <ChevronRight :size="14" class="mb-px inline" />
            <span class="font-bold">{{ gamesStore.occurrence?.title }}</span>
        </h2>

        <template v-if="gamesStore.occurrence">
            <p
                class="text-muted-foreground my-2 px-4 text-sm"
                v-if="status === 'open' || status === 'initial'"
            >
                Départ à {{ gamesStore.occurrence.start_at_time }}
            </p>
            <p
                class="text-muted-foreground my-2 px-4 text-sm"
                v-else-if="status === 'started'"
            >
                En cours
            </p>
            <p
                class="text-muted-foreground my-2 px-4 text-sm"
                v-else-if="status === 'ranked'"
            >
                Terminée
            </p>

            <Competitors
                :competitors="gamesStore.occurrence.competitors"
                :ranking="
                    status === 'ranked' ? gamesStore.occurrence.ranking : null
                "
                :showBettors="['ranked', 'started'].includes(status)"
            >
                <template #actions="{ competitor }">
                    <ValidationDrawer
                        v-if="!existingBet && status === 'open'"
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
                    <ValidationDrawer
                        v-if="status === 'initial'"
                        trigger="Ouvrir les paris"
                        :title="`Ouvrir les paris&nbsp;?`"
                        :action="() => open()"
                    >
                        <template #validation> Oui </template>
                    </ValidationDrawer>
                    <ValidationDrawer
                        v-if="status === 'open'"
                        trigger="Démarrer"
                        :title="`Fermer les paris et démarrer la course&nbsp;?`"
                        :action="() => start()"
                    >
                        <template #validation> Oui </template>
                    </ValidationDrawer>
                    <RouterLink
                        v-if="status === 'started'"
                        :to="{ name: 'race-ranking' }"
                    >
                        <Button class="w-full">Faire classement</Button>
                    </RouterLink>
                    <Button
                        variant="link"
                        as="a"
                        :href="`/admin/occurrences/${gamesStore.occurrence.id}`"
                    >
                        Ouvrir sur la console admin
                    </Button>
                </div>
            </IfAuth>
        </template>
        <Spinner v-else-if="gamesStore.fetching" class="m-4"></Spinner>
    </Layout>
</template>
