<script setup>
import SvgBoxer from "./SvgBoxer.vue";
import { useBoxingStore } from "../stores/boxing";
import TossAnimation from "./TossAnimation.vue";
import { Pause } from "lucide-vue-next";
import { useSpotifyStore } from "@/stores/spotify";

const boxingStore = useBoxingStore();
const spotifyStore = useSpotifyStore();
</script>

<template>
    <Transition>
        <div v-if="boxingStore.running">
            <SvgBoxer v-for="fighter in boxingStore.fighters" :fighter />
            <Transition>
                <div
                    v-if="spotifyStore.playback?.is_playing === false"
                    class="absolute top-0 flex h-full w-full flex-col items-center justify-center"
                >
                    <Pause fill="white" class="size-[10cqw]" />
                </div>
                <TossAnimation v-else-if="boxingStore.tossAnimation" />
            </Transition>
        </div>
    </Transition>
</template>

<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
