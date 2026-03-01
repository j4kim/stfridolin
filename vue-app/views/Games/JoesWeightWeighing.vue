<script setup>
import Layout from "@/components/Layout.vue";
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

const bets = ref([]);

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

        <ItemGroup>
            <ItemSeparator />
            <template v-for="bet in gamesStore.occurrence.bets" :key="bet.id">
                <Item>
                    <ItemContent>
                        <div>
                            <ItemTitle
                                >{{ bet.meta.prediction / 1000 }} kg</ItemTitle
                            >
                            <ItemDescription>
                                {{ bet.guest.name }}
                            </ItemDescription>
                        </div>
                    </ItemContent>
                    <ItemActions> </ItemActions>
                </Item>
                <ItemSeparator />
            </template>
        </ItemGroup>
    </Layout>
</template>
