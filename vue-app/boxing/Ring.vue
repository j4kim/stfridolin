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
        class="@container flex aspect-video flex-col"
        :style="{
            backgroundImage: `url(${ring})`,
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            backgroundRepeat: 'no-repeat',
        }"
    >
        <div class="flex aspect-240/35 flex-col">
            <h1
                class="text-center text-[2cqw] font-bold tracking-widest uppercase"
            >
                <RouterLink to="/"> Jukeboxe </RouterLink>
            </h1>
            <CurrentTrack class="grow" />
            <div class="text-center text-[1.6cqw]">
                Combat pour le prochain morceau
            </div>
        </div>
        <div class="flex grow" v-if="fightStore.fight">
            <TrackData
                class="-mr-[8cqw] w-[26cqw]"
                :track="fightStore.fight.left_track"
            />
            <div class="relative flex grow-4 flex-col">
                <Boxers class="grow" />
                <div class="w-full text-center text-[1.3cqw]">
                    Utilisez l'application pour ajouter un concurrent
                </div>
            </div>
            <TrackData
                class="-ml-[8cqw] w-[26cqw]"
                :track="fightStore.fight.right_track"
            />
        </div>
    </div>
</template>
