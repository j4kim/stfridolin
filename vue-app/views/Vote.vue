<script setup>
import { post } from "@/api";
import { useMainStore } from "@/stores/main";
import { useFightStore } from "@/stores/fight";
import Button from "@/components/ui/button/Button.vue";
import {
    Item,
    ItemContent,
    ItemActions,
    ItemMedia,
} from "@/components/ui/item";
import ValidationDrawer from "@/components/ValidationDrawer.vue";

const mainStore = useMainStore();

const fightStore = useFightStore();

fightStore.fetchCurrentFight();

async function vote(track) {
    return await post("votes.vote", [fightStore.fight.id, track.id]);
}
</script>

<template>
    <h1 class="p-4 text-2xl">
        {{ mainStore.appName }}
    </h1>
    <div class="my-2 px-4 font-bold">Combat en cours</div>
    <div class="flex flex-col border-t" v-if="fightStore.fight">
        <Item
            v-for="track in [
                fightStore.fight.left_track,
                fightStore.fight.right_track,
            ]"
            class="border-border rounded-none border-0 border-b"
        >
            <ItemMedia>
                <img
                    class="rounded-box size-10"
                    :src="track.img_thumbnail_url"
                />
            </ItemMedia>
            <ItemContent>
                <div>{{ track.name }}</div>
                <div class="text-xs font-semibold opacity-60">
                    {{ track.artist_name }}
                </div>
            </ItemContent>
            <ItemActions>
                <ValidationDrawer
                    trigger="Voter"
                    :title="`Voter pour ${track.name} ?`"
                    :action="() => vote(track)"
                    submitBtn="Dépenser 1 jeton"
                ></ValidationDrawer>
            </ItemActions>
        </Item>
    </div>

    <div class="mt-8 px-4">
        <Button class="w-full"> Ajouter un morceau en file d'attente </Button>
    </div>
</template>
