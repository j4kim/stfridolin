<script setup>
import Boxers from "@/boxing/Boxers.vue";
import ring from "@/boxing/svg/ring.svg";
import { useBoxingStore } from "@/stores/boxing";
import TrackData from "@/boxing/TrackData.vue";
import CurrentTrack from "@/boxing/CurrentTrack.vue";
import { useFightStore } from "@/stores/fight";

const fightStore = useFightStore();
const boxingStore = useBoxingStore();

fightStore.fetchCurrentFight().then(() => {
    const fight = fightStore.fight;
    boxingStore.fighters.left.imgUrl = fight.left_track.img_url;
    boxingStore.fighters.right.imgUrl = fight.right_track.img_url;
});
</script>

<template>
    <div
        v-if="fightStore.fight"
        class="flex aspect-video flex-col"
        :style="{
            backgroundImage: `url(${ring})`,
        }"
    >
        <div class="flex aspect-240/35 flex-col">
            <div
                class="text-center text-[2vw] font-bold tracking-widest uppercase"
            >
                Jukeboxe
            </div>
            <CurrentTrack class="grow" />
            <div class="text-center text-[1.6vw]">
                Combat pour le prochain morceau
            </div>
        </div>
        <div class="flex grow">
            <TrackData
                class="-mr-[8vw] grow"
                :track="fightStore.fight.left_track"
            />
            <div class="relative aspect-3/2 h-full">
                <div class="absolute h-full w-full">
                    <Boxers />
                    <div
                        class="absolute bottom-0 w-full text-center text-[1.3vw]"
                    >
                        Utilisez l'application pour ajouter un concurrent
                    </div>
                </div>
            </div>
            <TrackData
                class="-ml-[8vw] grow"
                :track="fightStore.fight.right_track"
            />
        </div>
    </div>
</template>
