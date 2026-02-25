<script setup>
import Competitors from "@/components/Competitors.vue";
import Layout from "@/components/Layout.vue";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { useGamesStore } from "@/stores/games";
import { ChevronRight } from "lucide-vue-next";
import { computed, ref } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const gamesStore = useGamesStore();

gamesStore.fetchGamesIfNeeded();

const occurrence = computed(() =>
    gamesStore.marbleRace?.occurrences.find((o) => o.id == route.params.occId),
);

const rank = ref(1);

const ranking = ref({});

function setRanking(competitor) {
    ranking.value[competitor.id] = rank.value;
    rank.value += 1;
}

function reset() {
    rank.value = 1;
    ranking.value = {};
}

const submitting = ref(false);

async function submit() {
    submitting.value = true;
    await gamesStore
        .setRanking(occurrence.value, ranking.value)
        .finally(() => (submitting.value = false));
}
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
            <Competitors
                :competitors="occurrence.competitors"
                @item-click="(c) => setRanking(c)"
            >
                <template #actions="{ competitor }">
                    <Input
                        class="w-12"
                        type="number"
                        v-model="ranking[competitor.id]"
                    />
                </template>
            </Competitors>
            <div class="flex flex-col gap-4 p-4">
                <Button variant="outline" @click="reset">Reset</Button>
                <Button
                    @click="submit"
                    :disabled="
                        Object.keys(ranking).length == 0 || submitting.value
                    "
                >
                    <Spinner v-if="submitting.value" class="mr-2" />
                    Valider
                </Button>
            </div>
        </template>

        <Spinner v-else-if="gamesStore.fetchingGames" class="m-4"></Spinner>
    </Layout>
</template>
