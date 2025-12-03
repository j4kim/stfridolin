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

const baseTl = gsap.timeline({ repeat: -1, yoyo: true });

onMounted(() => {
    const animables = root.value.querySelectorAll("path, use");
    Array.from(animables).forEach((el) => {
        const toSel = `#frame-2 [data-name=${el.dataset.name}]`;
        const toEl = document.querySelector(toSel);
        const vars = { ease: "power1.inOut", duration: animBodyDuration };
        if (el.nodeName === "path") {
            vars.morphSVG = toEl;
        } else if (el.nodeName === "use") {
            vars.transform = toEl.attributes.transform.value;
        }
        baseTl.to(el, vars, 0);
    });
});
</script>

<template>
    <g
        :class="{ reversed }"
        v-html="initialSvgContent"
        ref="root"
        :style="{
            '--animBackArmDuration': `${animBackArmDuration}s`,
            '--animFrontArmDuration': `${animFrontArmDuration}s`,
        }"
    ></g>
</template>

<style>
g.reversed {
    transform: scale(-1, 1);
    transform-origin: center;
}

@keyframes animatearms {
    0% {
        rotate: 0deg;
    }
    100% {
        rotate: 10deg;
    }
}
g[data-name^="arm_"] {
    animation: animatearms infinite ease-in-out alternate;
}
g[data-name="arm_back"] {
    transform-origin: 28% 39%;
    animation-duration: var(--animBackArmDuration);
}
g[data-name="arm_front"] {
    transform-origin: 28% 39%;
    animation-duration: var(--animFrontArmDuration);
}
</style>
