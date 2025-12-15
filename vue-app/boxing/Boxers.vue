<script setup>
import SvgBoxer from "./SvgBoxer.vue";
import { useBoxingStore } from "../stores/boxing";

const boxingStore = useBoxingStore();

boxingStore.fighters.left.imgUrl =
    "https://i.scdn.co/image/ab67616d0000b27389b9e48b79603248d4fea627";

boxingStore.fighters.right.imgUrl =
    "https://i.scdn.co/image/ab67616d0000b2734e09836e2d1938337c416bf2";
</script>

<template>
    <div v-if="!boxingStore.finished" class="flex gap-2">
        <button @click="boxingStore.punch('left')" class="btn btn-xs">
            left punch
        </button>
        <button @click="boxingStore.punch('right')" class="btn btn-xs">
            right punch
        </button>
        <button @click="boxingStore.win('left')" class="btn btn-xs">
            left wins
        </button>
        <button @click="boxingStore.win('right')" class="btn btn-xs">
            right wins
        </button>
    </div>
    <div v-else class="flex gap-2">
        <button
            v-if="boxingStore.running"
            @click="boxingStore.running = false"
            class="btn btn-xs"
        >
            stop
        </button>
        <button v-else @click="boxingStore.run" class="btn btn-xs">run</button>
    </div>
    <div class="relative aspect-3/2 max-h-[80vh] w-full">
        <SvgBoxer
            v-if="boxingStore.running"
            v-for="fighter in boxingStore.fighters"
            :fighter
        />
    </div>
</template>
