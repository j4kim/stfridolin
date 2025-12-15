<script setup>
import SvgBoxer from "./SvgBoxer.vue";
import { useBoxingStore } from "../stores/boxing";
import { ref } from "vue";

const boxingStore = useBoxingStore();

boxingStore.fighters.left.imgUrl =
    "https://i.scdn.co/image/ab67616d0000b27389b9e48b79603248d4fea627";

boxingStore.fighters.right.imgUrl =
    "https://i.scdn.co/image/ab67616d0000b2734e09836e2d1938337c416bf2";

const running = ref(false);
</script>

<template>
    <div class="flex gap-2">
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
        <button @click="running = true" class="btn btn-xs">run</button>
        <button @click="running = false" class="btn btn-xs">stop</button>
    </div>
    <div class="relative aspect-3/2 max-h-[80vh] w-full">
        <SvgBoxer
            v-if="running"
            v-for="fighter in boxingStore.fighters"
            :fighter
        />
    </div>
</template>
