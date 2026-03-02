<script setup>
import Layout from "@/components/Layout.vue";
import RaceOccurenceItem from "@/components/RaceOccurenceItem.vue";
import Button from "@/components/ui/button/Button.vue";
import { ItemGroup, ItemSeparator } from "@/components/ui/item";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import WhereIsJoeHeader from "@/components/WhereIsJoeHeader.vue";
import { useGamesStore } from "@/stores/games";
import { useMainStore } from "@/stores/main";
import { computed } from "vue";

const gamesStore = useGamesStore();
const mainStore = useMainStore();

const occurrences = computed(() => gamesStore.game?.occurrences || []);
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">{{ gamesStore.game?.title }}</h2>

        <WhereIsJoeHeader
            v-if="gamesStore.gameName === 'where-is-joe'"
            class="my-2 flex flex-col gap-4 px-4"
        />

        <ItemGroup v-if="occurrences.length">
            <ItemSeparator />
            <template v-for="(occ, index) in occurrences" :key="occ.id">
                <RaceOccurenceItem
                    :occ="occ"
                    :showBetsOpenAt="
                        gamesStore.game.type === 'race' &&
                        occ.status === 'initial'
                    "
                >
                    <template
                        v-if="gamesStore.gameName === 'where-is-joe'"
                        #actions="{ disabled, goToOcc, buttonText }"
                    >
                        <Button
                            v-show="
                                gamesStore.guestParticipates || mainStore.user
                            "
                            :disabled
                            @click="goToOcc"
                        >
                            {{ buttonText }}
                        </Button>
                    </template>
                </RaceOccurenceItem>
                <ItemSeparator />
            </template>
        </ItemGroup>
        <Spinner v-else-if="gamesStore.fetching" class="m-4"></Spinner>
    </Layout>
</template>
