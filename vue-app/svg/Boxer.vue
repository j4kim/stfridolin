<script setup>
import { onMounted, ref, useTemplateRef } from "vue";
import { gsap } from "gsap";

import { MorphSVGPlugin } from "gsap/MorphSVGPlugin";

gsap.registerPlugin(MorphSVGPlugin);

const max = 1.1;
const min = 0.7;
const animBackArmDuration = Math.random() * (max - min) + min;
const animFrontArmDuration = Math.random() * (max - min) + min;
const animBodyDuration = Math.random() * (max - min) + min;
const punchInDuration = 0.6;
const punchInPause = 0.2;
const punchOutDuration = 0.5;

const props = defineProps({
    imageUrl: String,
    reversed: Boolean,
    initialSvgContent: String,
});

const g = useTemplateRef("g");

const baseTl = gsap.timeline({ repeat: -1, yoyo: true });

const punchTl = gsap.timeline({ paused: true });

const animables = ref([]);

function addToTl(tl, frame, duration, ease = "power1.inOut", position = 0) {
    animables.value.forEach((el) => {
        const toSel = `#frame-${frame} [data-name=${el.dataset.name}]`;
        const toEl = document.querySelector(toSel);
        const vars = { ease, duration };
        if (el.nodeName === "path") {
            vars.morphSVG = toEl;
        } else if (el.nodeName === "use") {
            vars.transform = toEl.attributes.transform.value;
        }
        tl.to(el, vars, position);
    });
}

onMounted(() => {
    animables.value = Array.from(g.value.querySelectorAll("path, use"));
    addToTl(baseTl, 2, animBodyDuration, "power1.inOut", 0);
    addToTl(punchTl, 3, punchInDuration, "back.in(4)", 0);
    addToTl(
        punchTl,
        2,
        punchOutDuration,
        "power1.inOut",
        punchInDuration + punchInPause,
    );
});

function punch() {
    baseTl.pause();
    punchTl.restart().then(() => {
        baseTl.seek(animBodyDuration);
        const correctionTl = gsap.timeline();
        correctionTl.then(() => baseTl.resume());
        addToTl(correctionTl, 2, 0.1);
    });
}
</script>

<template>
    <g
        :class="{ reversed }"
        v-html="initialSvgContent"
        ref="g"
        :style="{
            '--animBackArmDuration': `${animBackArmDuration}s`,
            '--animFrontArmDuration': `${animFrontArmDuration}s`,
        }"
        @click="punch"
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
