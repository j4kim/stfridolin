<script setup>
import { useBoxingStore } from "../stores/boxing";

const boxingStore = useBoxingStore();

boxingStore.fetchCurrentFight();
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
            <button class="btn btn-primary">Voter</button>
        </li>
    </ul>
</template>
