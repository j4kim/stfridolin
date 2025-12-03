<script setup>
import { onMounted, useTemplateRef } from "vue";
import { gsap } from "gsap";

import { MorphSVGPlugin } from "gsap/MorphSVGPlugin";

gsap.registerPlugin(MorphSVGPlugin);

const max = 1.1;
const min = 0.7;
const animBackArmDuration = Math.random() * (max - min) + min;
const animFrontArmDuration = Math.random() * (max - min) + min;
const animBodyDuration = Math.random() * (max - min) + min;

const props = defineProps({
    imageUrl: String,
    reversed: Boolean,
    initialSvgContent: String,
});

const root = useTemplateRef("root");

onMounted(() => {
    const duration = animBodyDuration;
    const ease = "power1.inOut"; // "back.inOut" is cool too
    const animables = root.value.querySelectorAll("path");
    Array.from(animables).forEach((el) => {
        const toEl = document.querySelector(
            `#frame-2 [data-name=${el.dataset.name}]`,
        );
        gsap.to(el, { duration, morphSVG: toEl, repeat: -1, yoyo: true, ease });
    });
});
</script>

<template>
    <g :class="{ reversed }" v-html="initialSvgContent" ref="root"></g>
</template>

<style scoped>
g.reversed {
    transform: scale(-1, 1);
    transform-origin: center;
}
</style>
