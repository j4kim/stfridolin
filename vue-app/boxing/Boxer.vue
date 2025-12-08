<script setup>
import { onMounted, ref, useTemplateRef } from "vue";
import { gsap } from "gsap";
import { MorphSVGPlugin } from "gsap/MorphSVGPlugin";
import { addToTl, Fighter } from "./utils";

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
    id: String,
    imageUrl: String,
    reversed: Boolean,
    initialSvgContent: String,
});

const g = useTemplateRef("g");

const fighter = new Fighter(props.id);

onMounted(() => {
    fighter.mount(Array.from(g.value.querySelectorAll("path, use")));
    addToTl(
        fighter.animables,
        fighter.baseTl,
        1,
        2,
        animBodyDuration,
        "power1.inOut",
        0,
    );
    addToTl(
        fighter.animables,
        fighter.punchTl,
        1,
        3,
        punchInDuration,
        "back.in(3)",
        0,
    );
    addToTl(
        fighter.animables,
        fighter.punchTl,
        3,
        2,
        punchOutDuration,
        "power1.inOut",
        punchInDuration + punchInPause,
    );
});

function punch() {
    fighter.baseTl.pause();
    return fighter.punchTl.restart().then(() => {
        fighter.baseTl.seek(animBodyDuration);
        const correctionTl = gsap.timeline();
        correctionTl.then(() => fighter.baseTl.resume());
        addToTl(fighter.animables, correctionTl, 2, 2, 0.1);
    });
}
</script>

<template>
    <g
        :id
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
