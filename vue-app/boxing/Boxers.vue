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
        <div
            v-for="fighter in boxingStore.fighters"
            class="flex flex-col gap-2"
        >
            {{ fighter.id }}
            <div v-for="(a, name) in fighter.animations" class="flex gap-2">
                <div class="w-12">{{ name }}</div>
                <button
                    v-for="action in [
                        'play',
                        'pause',
                        'resume',
                        'kill',
                        'restart',
                    ]"
                    class="btn btn-xs"
                    @click="a.tl[action]()"
                >
                    {{ action }}
                </button>
            </div>
        </div>
    </div>
</template>
