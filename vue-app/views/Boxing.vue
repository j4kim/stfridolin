<script setup>
import Boxers from "../boxing/Boxers.vue";
import ring from "../boxing/svg/ring.svg";
import BoxingControls from "../boxing/BoxingControls.vue";
import { useBoxingStore } from "../stores/boxing";

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
            <div class="-mr-[6vw] grow p-[1vw] text-center">
                <div class="text-[2.2vw] font-semibold">
                    {{ boxingStore.fight.left_track.name }}
                </div>
                <div class="text-[2.2vw] font-light">
                    {{ boxingStore.fight.left_track.artist_name }}
                </div>
                <div class="text-[10vw] leading-none font-bold">2</div>
                <div class="text-[2.2vw] font-bold">votes</div>
            </div>
            <div class="aspect-3/2 h-full">
                <Boxers />
            </div>
            <div class="-ml-[6vw] grow p-[1vw] text-center">
                <div class="text-[2.2vw] font-semibold">
                    {{ boxingStore.fight.right_track.name }}
                </div>
                <div class="text-[2.2vw] font-light">
                    {{ boxingStore.fight.right_track.artist_name }}
                </div>
                <div class="text-[10vw] leading-none font-bold">9</div>
                <div class="text-[2.2vw] font-bold">votes</div>
            </div>
        </div>
    </div>
    <BoxingControls class="mt-2" />
</template>
