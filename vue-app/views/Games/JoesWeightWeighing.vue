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

async function setWeighing() {
    setting.value = true;
    const meta = { weighing: weighing.value };
    const res = await gamesStore
        .finish(occurrence.value.id, meta)
        .finally(() => (setting.value = false));
}

const sortedBets = computed(() => {
    if (!gamesStore.occurrence?.bets) return [];
    const bets = gamesStore.occurrence.bets;
    const weighing = gamesStore.occurrence.meta.weighing;
    if (!weighing) return bets;
    return bets
        .map((b) => ({ ...b, diff: b.meta.prediction - weighing }))
        .map((b) => ({ ...b, absDiff: Math.abs(b.diff) }))
        .sort((a, b) => a.absDiff - b.absDiff);
});
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
                @click="setWeighing"
                :disabled="!weighing || !gamesStore.occurrence || setting"
                >Valider la pesée</Button
            >
        </div>

        <div class="my-8 px-4" v-if="gamesStore.occurrence?.meta.weighing">
            Poids pesé:
            <strong>{{ occurrence.meta.weighing / 1000 }} kg</strong>
        </div>

        <ItemGroup>
            <ItemSeparator />
            <template v-for="bet in sortedBets" :key="bet.id">
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
