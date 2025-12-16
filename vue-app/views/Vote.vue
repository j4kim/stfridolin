<script setup>
import { ref, useTemplateRef } from "vue";
import { useBoxingStore } from "../stores/boxing";

const boxingStore = useBoxingStore();

boxingStore.fetchCurrentFight();

const dialog = useTemplateRef("dialog");

const track = ref(null);

function select(t) {
    track.value = t;
    dialog.value.showModal();
}

function vote() {
    // todo
    dialog.value.close();
}
</script>

<template>
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

    <dialog ref="dialog" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Voter pour {{ track?.name }} ?</h3>
            <div class="modal-action flex flex-col">
                <button class="btn btn-primary w-full" @click="vote">
                    Dépenser 1 jeton
                </button>
                <button class="btn btn-ghost w-full" @click="dialog.close">
                    Annuler
                </button>
            </div>
        </div>
    </dialog>
</template>
