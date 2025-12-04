<script setup>
import Boxer from "./Boxer.vue";
import { useBoxingStore } from "../stores/boxing";

const boxingStore = useBoxingStore();
</script>

<template>
    <div>
        <svg class="max-h-[80vh] w-full" viewBox="0 0 1500 1000">
            <template v-for="boxer in boxingStore.boxers">
                <defs>
                    <g
                        v-for="svg in boxer.svgFrames"
                        :id="svg.id"
                        v-html="svg.content"
                    ></g>
                    <image
                        :id="boxer.imageId"
                        width="4px"
                        height="4px"
                        :href="boxer.imgUrl"
                    />
                </defs>
                <Boxer id="boxer-left" :boxer />
            </template>
        </svg>
    </div>
</template>
