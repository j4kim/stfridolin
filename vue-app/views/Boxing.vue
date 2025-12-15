<script setup>
import Boxers from "../boxing/Boxers.vue";
import ring from "../boxing/svg/ring.svg";
import BoxingControls from "../boxing/BoxingControls.vue";
import { useBoxingStore } from "../stores/boxing";
import TrackData from "../boxing/TrackData.vue";

const boxingStore = useBoxingStore();

boxingStore.fetchCurrentFight();
</script>

<template>
    <div
        v-if="boxingStore.fight"
        class="flex aspect-video flex-col"
        :style="{
            backgroundImage: `url(${ring})`,
        }"
    >
        <div class="flex aspect-240/35 flex-col">
            <div class="grow"></div>
            <div class="text-center text-[1.6vw]">
                Combat pour le prochain morceau
            </div>
        </div>
        <div class="flex grow">
            <TrackData
                class="-mr-[8vw] grow"
                :track="boxingStore.fight.left_track"
            />
            <div class="relative aspect-3/2 h-full">
                <div class="absolute h-full w-full">
                    <Boxers />
                    <div
                        class="absolute bottom-0 w-full p-[1vw] text-center text-[1.3vw]"
                    >
                        Utilisez l'application pour ajouter un concurrent
                    </div>
                </div>
            </div>
            <TrackData
                class="-ml-[8vw] grow"
                :track="boxingStore.fight.right_track"
            />
        </div>
    </div>
    <BoxingControls class="mt-2" />
</template>
