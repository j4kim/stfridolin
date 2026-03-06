<script setup>
import AnimatedCount from "@/components/AnimatedCount.vue";
import Competitors from "@/components/Competitors.vue";
import IfAuth from "@/components/IfAuth.vue";
import Layout from "@/components/Layout.vue";
import { AlertTitle, Alert, AlertDescription } from "@/components/ui/alert";
import Badge from "@/components/ui/badge/Badge.vue";
import Button from "@/components/ui/button/Button.vue";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import ValidationDrawer from "@/components/ValidationDrawer.vue";
import { useGamesStore } from "@/stores/games";
import { useGuestStore } from "@/stores/guest";
import { icon } from "@/translate";
import { ArrowRight, ChevronRight } from "lucide-vue-next";
import { computed } from "vue";
import { onBeforeRouteUpdate, useRoute } from "vue-router";
import { toast } from "vue-sonner";

const route = useRoute();

const gamesStore = useGamesStore();
const guestStore = useGuestStore();

gamesStore.fetchOccurrence(route.params.occId);

const status = computed(() => gamesStore.occurrence?.status);

const existingBet = computed(() => {
    return guestStore.movements.find(
        (m) =>
            m.occurrence_id === gamesStore.occurrence?.id &&
            m.type === "race-bet",
    );
});

const articleName = computed(() => {
    return {
        "marble-race": "bet-on-a-marble",
        "horse-show": "bet-on-horse",
        "where-is-joe": "where-is-joe-bet",
    }[route.params.gameName];
});

async function bet(competitor) {
    const result = await gamesStore.betOn(competitor, articleName.value);
    toast.success(result.message);
}

async function open() {
    const result = await gamesStore.openRace();
    toast.success(result.message);
}

async function close() {
    const result = await gamesStore.closeRace();
    toast.success(result.message);
}

async function start() {
    const result = await gamesStore.startRace();
    toast.success(result.message);
}

const nextOccurrence = computed(() => {
    const occs = gamesStore.game?.occurrences;
    if (!occs.length) return null;
    const idx = occs.findIndex((o) => o.id == route.params.occId);
    if (idx < 0) return null;
    if (idx === occs.length - 1) return null;
    return occs[idx + 1];
});

onBeforeRouteUpdate((to) => {
    gamesStore.fetchOccurrence(to.params.occId);
});

const statusText = computed(() => {
    if (route.params.gameName === "where-is-joe") {
        return {
            started: "Regarde la vidéo",
            open: "Qui est l'intrus ?",
            closed: "En attente du verdict...",
            ranked: "Manche terminée",
        }[status.value];
    }
    return {
        initial: `Départ à ${gamesStore.occurrence?.start_at_time}`,
        open: `Faites vos jeux !`,
        started: `En cours`,
        ranked: `Terminé`,
    }[status.value];
});
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">
            <RouterLink :to="{ name: 'race-index' }">{{
                gamesStore.game?.title
            }}</RouterLink>
            <ChevronRight :size="14" class="mb-px inline" />
            <span class="font-bold">{{ gamesStore.occurrence?.title }}</span>
        </h2>

        <template v-if="gamesStore.occurrence">
            <p
                class="text-muted-foreground my-2 px-4 text-sm"
                v-if="statusText"
            >
                {{ statusText }}
            </p>

            <div v-if="existingBet?.points" class="my-4 px-4">
                <Alert>
                    <component :is="icon('points')" />
                    <AlertTitle>C'est gagné !!</AlertTitle>
                    <AlertDescription>
                        <p>
                            Bravo, Tu reçois
                            <AnimatedCount
                                :startVal="0"
                                :value="existingBet.points"
                            />
                            points !
                        </p>
                    </AlertDescription>
                </Alert>
            </div>

            <div
                class="my-2 px-4"
                v-if="
                    gamesStore.gameName === 'where-is-joe' &&
                    status === 'ranked' &&
                    nextOccurrence
                "
            >
                <RouterLink :to="{ params: { occId: nextOccurrence.id } }">
                    <Button class="w-full" variant="outline">
                        <ArrowRight />
                        Manche suivante
                    </Button>
                </RouterLink>
            </div>

            <Competitors
                v-if="
                    !(
                        gamesStore.gameName === 'where-is-joe' &&
                        status === 'started'
                    )
                "
                :competitors="gamesStore.occurrence.competitors"
                :ranking="
                    status === 'ranked' ? gamesStore.occurrence.ranking : null
                "
                :showBettors="status === 'ranked'"
            >
                <template #rank="{ rank }">
                    <div
                        v-if="gamesStore.gameName === 'where-is-joe'"
                        class="w-8"
                    >
                        <span v-if="rank === 1">intrus</span>
                    </div>
                    <div v-else class="w-6">
                        <span v-if="rank === Infinity"> DNF </span>
                        <Badge v-else>{{ rank }}</Badge>
                    </div>
                </template>
                <template #actions="{ competitor }">
                    <ValidationDrawer
                        v-if="!existingBet && status === 'open'"
                        trigger="Choisir"
                        :title="`Parier sur ${competitor.name}&nbsp;?`"
                        :action="() => bet(competitor)"
                        :articleName="articleName"
                        :disabled="gamesStore.betting"
                    ></ValidationDrawer>
                    <Badge v-if="existingBet?.competitor_id === competitor.id">
                        Ton pari
                    </Badge>
                </template>
            </Competitors>

            <IfAuth>
                <div class="mb-12 flex flex-col gap-4 p-4">
                    <template v-if="gamesStore.gameName === 'where-is-joe'">
                        <ValidationDrawer
                            v-if="status === 'started'"
                            trigger="Ouvrir les paris"
                            :title="`Ouvrir les paris&nbsp;?`"
                            :action="() => open()"
                        />
                        <ValidationDrawer
                            v-if="status === 'open'"
                            trigger="Fermer les paris"
                            :title="`Fermer les paris&nbsp;?`"
                            :action="() => close()"
                        />
                        <RouterLink
                            v-if="status === 'closed'"
                            :to="{ name: 'race-ranking' }"
                        >
                            <Button class="w-full">Faire classement</Button>
                        </RouterLink>
                    </template>
                    <template v-else>
                        <ValidationDrawer
                            v-if="status === 'initial'"
                            trigger="Ouvrir les paris"
                            :title="`Ouvrir les paris&nbsp;?`"
                            :action="() => open()"
                        />
                        <ValidationDrawer
                            v-if="status === 'open'"
                            trigger="Démarrer"
                            :title="`Fermer les paris et démarrer la course&nbsp;?`"
                            :action="() => start()"
                        />
                        <RouterLink
                            v-if="status === 'started'"
                            :to="{ name: 'race-ranking' }"
                        >
                            <Button class="w-full">Faire classement</Button>
                        </RouterLink>
                        <RouterLink :to="{ name: 'race-video' }">
                            <Button class="w-full" variant="link"
                                >Intégration vidéo</Button
                            >
                        </RouterLink>
                    </template>
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
