<script setup>
import Layout from "@/components/Layout.vue";
import Badge from "@/components/ui/badge/Badge.vue";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import {
    Item,
    ItemActions,
    ItemContent,
    ItemDescription,
    ItemGroup,
    ItemSeparator,
    ItemTitle,
} from "@/components/ui/item";
import { useGamesStore } from "@/stores/games";
import { ChevronRight } from "lucide-vue-next";
import { computed, ref, watch } from "vue";
import { mean } from "lodash-es";

const gamesStore = useGamesStore();

const occurrence = computed(() => gamesStore.game?.occurrences[0]);

watch(
    occurrence,
    (o) => {
        if (!o) {
            return;
        }
        gamesStore.fetchOccurrence(o.id, { withBets: true });
    },
    { immediate: true },
);

const weighing = ref(null);
const setting = ref(false);

async function finish() {
    setting.value = true;
    const meta = { weighing: weighing.value };
    const res = await gamesStore
        .finish(occurrence.value.id, meta)
        .finally(() => (setting.value = false));
}

const orderedBets = computed(() => {
    if (!gamesStore.occurrence?.bets) return [];
    const bets = gamesStore.occurrence.bets;
    return bets.sort((a, b) => a.meta.prediction - b.meta.prediction);
});

const rankedBets = computed(() => {
    const weighing = gamesStore.occurrence?.meta.weighing;
    if (!weighing) return orderedBets.value;
    return orderedBets.value
        .map((b) => ({ ...b, diff: b.meta.prediction - weighing }))
        .map((b) => ({ ...b, absDiff: Math.abs(b.diff) }))
        .sort((a, b) => a.absDiff - b.absDiff);
});

const allPredi = computed(() =>
    orderedBets.value.map((b) => b.meta.prediction / 1000),
);
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">
            <RouterLink :to="{ name: 'joes-weight' }">
                {{ gamesStore.game?.title }}
            </RouterLink>
            <ChevronRight :size="14" class="mb-px inline" />
            <span class="font-bold">Pesée</span>
        </h2>

        <div class="my-8 flex flex-col gap-4 px-4">
            <Input v-model="weighing" />
            <Button
                class="w-full"
                @click="finish"
                :disabled="!gamesStore.occurrence || setting"
                v-text="weighing ? 'Valider la pesée' : 'Fermer les paris'"
            ></Button>
        </div>

        <div class="my-8 px-4" v-if="gamesStore.occurrence?.meta.weighing">
            Poids pesé:
            <strong>{{ occurrence.meta.weighing / 1000 }} kg</strong>
        </div>

        <div class="my-4 px-4 text-sm">
            <div>{{ allPredi.length }} paris</div>
            <div v-if="allPredi.length">
                Min: <strong>{{ allPredi[0] }} kg</strong>
            </div>
            <div v-if="allPredi.length">
                Max: <strong>{{ allPredi[allPredi.length - 1] }} kg</strong>
            </div>
            <div>
                Moyenne: <strong>{{ mean(allPredi).toFixed(3) }} kg</strong>
            </div>
        </div>

        <ItemGroup>
            <ItemSeparator />
            <template v-for="bet in rankedBets" :key="bet.id">
                <Item>
                    <ItemContent>
                        <div>
                            <ItemTitle>
                                {{ bet.guest.name }}
                            </ItemTitle>
                            <ItemDescription>
                                {{ bet.meta.prediction / 1000 }} kg
                            </ItemDescription>
                        </div>
                    </ItemContent>
                    <Badge v-if="bet.diff !== undefined" class="gap-0">
                        <span v-if="bet.diff > 0">+</span>
                        {{ bet.diff }} g
                    </Badge>
                    <ItemActions></ItemActions>
                </Item>
                <ItemSeparator />
            </template>
        </ItemGroup>
    </Layout>
</template>
