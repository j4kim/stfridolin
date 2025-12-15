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
        <div class="aspect-240/35"></div>
        <div class="flex grow">
            <TrackData
                class="-mr-[6vw] grow"
                :track="boxingStore.fight.left_track"
            />
            <div class="aspect-3/2 h-full">
                <Boxers />
            </div>
            <TrackData
                class="-ml-[6vw] grow"
                :track="boxingStore.fight.right_track"
            />
        </div>
    </div>
    <BoxingControls class="mt-2" />
</template>
