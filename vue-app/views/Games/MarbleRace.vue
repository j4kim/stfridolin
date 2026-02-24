<script setup>
import Layout from "@/components/Layout.vue";
import Button from "@/components/ui/button/Button.vue";
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
import { computed } from "vue";

const gamesStore = useGamesStore();

gamesStore.fetchGames();

const occurrences = computed(
    () => gamesStore.byName["marble-race"]?.occurrences || [],
);

function time(datetime) {
    return new Date(datetime).toLocaleTimeString([], {
        timeStyle: "short",
    });
}
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">Course de billes</h2>

        <ItemGroup v-if="occurrences.length">
            <ItemSeparator />
            <template v-for="occ in occurrences" :key="occ.id">
                <Item>
                    <ItemContent>
                        <div>
                            <ItemTitle>{{ occ.title }}</ItemTitle>
                            <ItemDescription>
                                De
                                {{ time(occ.start_at) }}
                                à
                                {{ time(occ.end_at) }}
                            </ItemDescription>
                        </div>
                    </ItemContent>
                    <ItemActions>
                        <Button disabled> C'est trop tôt </Button>
                    </ItemActions>
                </Item>
                <ItemSeparator />
            </template>
        </ItemGroup>
    </Layout>
</template>
