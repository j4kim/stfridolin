<script setup>
import Boxer from "./Boxer.vue";
import { useBoxingStore } from "../stores/boxing";

const boxingStore = useBoxingStore();

boxingStore.fighters.left.imgUrl =
    "https://i.scdn.co/image/ab67616d0000b27389b9e48b79603248d4fea627";

boxingStore.fighters.right.imgUrl =
    "https://i.scdn.co/image/ab67616d0000b2734e09836e2d1938337c416bf2";
</script>

<template>
    <div>
        <svg class="max-h-[80vh] w-full" viewBox="0 0 1500 1000">
            <template v-for="fighter in boxingStore.fighters">
                <defs>
                    <g
                        v-for="frame in fighter.svgFrames"
                        :id="`${fighter.id}_${frame.id}`"
                        v-html="frame.content"
                        :data-frame-id="frame.id"
                        :data-fighter-id="fighter.id"
                    ></g>
                    <image
                        :id="fighter.imgId"
                        width="4px"
                        height="4px"
                        :href="fighter.imgUrl"
                    />
                </defs>
                <Boxer v-if="fighter.ready" :id="fighter.id" :fighter />
            </template>
        </svg>
    </div>
</template>
