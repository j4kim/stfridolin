<script setup>
import Boxer from "./Boxer.vue";

const props = defineProps({
    fighter: Object,
});
</script>

<template>
    <svg
        class="absolute top-0 h-full w-full"
        :class="{
            'z-10': fighter.punching,
        }"
        viewBox="0 0 1500 1000"
    >
        <defs>
            <g
                v-for="frame in fighter.svgFrames"
                :id="`${fighter.id}_${frame.id}`"
                v-html="frame.content"
                :data-frame-id="frame.id"
                :data-fighter-id="fighter.id"
            ></g>
            <image
                :id="fighter.headImgId"
                width="4px"
                height="4px"
                :href="fighter.headImgUrl"
            />
            <image
                :id="fighter.sponsorImgId"
                width="4px"
                height="4px"
                :href="fighter.sponsorImgUrl"
            />
        </defs>
        <Boxer :fighter />
    </svg>
</template>
