<script setup>
import { ref, useTemplateRef } from "vue";
import { useBoxingStore } from "../stores/boxing";
import { post } from "../api";
import { useMainStore } from "../stores/main";

const mainStore = useMainStore();

const boxingStore = useBoxingStore();

boxingStore.fetchCurrentFight();

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
        await post("votes.vote", [boxingStore.fight.id, track.value.id]);
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
    <ul class="list bg-base-100 rounded-box shadow-md" v-if="boxingStore.fight">
        <li
            v-for="{ side, track } in [
                { side: 'left', track: boxingStore.fight.left_track },
                { side: 'right', track: boxingStore.fight.right_track },
            ]"
            class="list-row"
        >
            <div>
                <img
                    class="rounded-box size-10"
                    :src="track.img_thumbnail_url"
                />
            </div>
            <div>
                <div>{{ track.name }}</div>
                <div class="text-xs font-semibold opacity-60">
                    {{ track.artist_name }}
                </div>
            </div>
            <button class="btn btn-primary" @click="select(track)">
                Voter
            </button>
        </li>
    </ul>

    <div class="mt-8 px-4">
        <button class="btn btn-primary w-full">
            Ajouter un morceau en file d'attente
        </button>
    </div>

    <dialog ref="dialog" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Voter pour {{ track?.name }} ?</h3>
            <div class="modal-action flex flex-col">
                <button
                    class="btn btn-primary w-full"
                    @click="vote"
                    :disabled="voting"
                >
                    <span v-if="voting" class="loading loading-spinner"></span>
                    Dépenser 1 jeton
                </button>
                <button class="btn btn-ghost w-full" @click="dialog.close">
                    Annuler
                </button>
            </div>
        </div>
    </dialog>
</template>
