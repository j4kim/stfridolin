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
    <div class="relative h-full w-full">
        <SvgBoxer
            v-if="boxingStore.running"
            v-for="fighter in boxingStore.fighters"
            :fighter
        />
    </div>
</template>
