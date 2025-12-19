<script setup>
import { ref, useTemplateRef } from "vue";
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

const mainStore = useMainStore();

const fightStore = useFightStore();

fightStore.fetchCurrentFight();

const dialog = useTemplateRef("dialog");

const track = ref(null);

function select(t) {
    track.value = t;
    dialog.value.showModal();
}

const voting = ref(false);

async function vote() {
    voting.value = true;
    try {
        await post("votes.vote", [fightStore.fight.id, track.value.id]);
        dialog.value.close();
    } catch (error) {
    } finally {
        voting.value = false;
    }
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
                <Button @click="select(track)"> Voter </Button>
            </ItemActions>
        </Item>
    </div>

    <div class="mt-8 px-4">
        <Button class="w-full"> Ajouter un morceau en file d'attente </Button>
    </div>

    <dialog ref="dialog" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Voter pour {{ track?.name }} ?</h3>
            <div class="modal-action flex flex-col">
                <Button class="w-full" @click="vote" :disabled="voting">
                    <span v-if="voting" class="loading loading-spinner"></span>
                    Dépenser 1 jeton
                </Button>
                <Button
                    class="w-full"
                    variant="secondary"
                    @click="dialog.close()"
                >
                    Annuler
                </Button>
            </div>
        </div>
    </dialog>
</template>
