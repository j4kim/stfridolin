<script setup>
import Boxer from "./Boxer.vue";
import { useBoxingStore } from "../stores/boxing";

const boxingStore = useBoxingStore();

boxingStore.fighters.left.imgUrl =
    "https://i.scdn.co/image/ab67616d0000b27389b9e48b79603248d4fea627";
</script>

<template>
    <div>
        <svg class="max-h-[80vh] w-full" viewBox="0 0 1500 1000">
            <template v-for="fighter in boxingStore.fighters">
                <defs>
                    <g
                        v-for="svg in fighter.svgFrames"
                        :id="svg.id"
                        v-html="svg.content"
                        :data-fighter-id="fighter.id"
                    ></g>
                    <image
                        :id="fighter.imgId"
                        width="4px"
                        height="4px"
                        :href="fighter.imgUrl"
                    />
                </defs>
                <Boxer :id="fighter.id" :fighter />
            </template>
        </svg>
    </div>
</template>
