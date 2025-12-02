<script setup>
import { onMounted, reactive, useTemplateRef } from "vue";
import { gsap } from "gsap";

import { MorphSVGPlugin } from "gsap/MorphSVGPlugin";
import boxerFrames from "./boxerFrames";

gsap.registerPlugin(MorphSVGPlugin);

const max = 1.1;
const min = 0.7;
const animBackArmDuration = Math.random() * (max - min) + min;
const animFrontArmDuration = Math.random() * (max - min) + min;
const animBodyDuration = Math.random() * (max - min) + min;

const props = defineProps({
    imageUrl: String,
    reversed: Boolean,
});

const svgState = reactive({
    leg_back: { paths: boxerFrames.leg_back.frame1.paths },
    arm_back: {
        paths: boxerFrames.arm_back.frame1.paths,
        cls: "arm",
        style: { animationDuration: `${animBackArmDuration}s` },
    },
    leg_front: { paths: boxerFrames.leg_front.frame1.paths },
    torso: { paths: boxerFrames.torso.frame1.paths },
    head: {
        image: {
            href: props.imageUrl,
            ...boxerFrames.head.frame1.image,
        },
    },
    arm_front: {
        paths: boxerFrames.arm_front.frame1.paths,
        cls: "arm",
        style: { animationDuration: `${animFrontArmDuration}s` },
    },
});

const animables = useTemplateRef("animables");

onMounted(() => {
    const duration = animBodyDuration;
    const ease = "power1.inOut"; // "back.inOut" is cool too
    animables.value.forEach((el) => {
        const [id, idx] = el.id.split("-");
        const toObj = boxerFrames[id].frame2;
        if (el.nodeName === "path") {
            const morphSVG = toObj.paths[idx];
            gsap.to(el, { duration, morphSVG, repeat: -1, yoyo: true, ease });
        } else if (el.nodeName === "image") {
            gsap.to(svgState[id].image, {
                duration,
                ...toObj.image,
                repeat: -1,
                yoyo: true,
                ease,
            });
        }
    });
});
</script>

<template>
    <g :class="{ reversed }">
        <g
            v-for="(group, id) in svgState"
            :id
            :class="group.cls"
            :style="group.style"
        >
            <path
                v-for="(d, idx) in group.paths"
                :d
                :id="`${id}-${idx}`"
                ref="animables"
            />
            <image
                v-if="group.image"
                :href="group.image.href"
                :x="group.image.x"
                :y="group.image.y"
                :width="group.image.width"
                :height="group.image.height"
                :style="{
                    scale: reversed ? '-1 1' : 'auto',
                    rotate: `${group.image.rotate}deg`,
                }"
                :id="`${id}-0`"
                ref="animables"
            />
        </g>
    </g>
</template>

<style scoped>
g.reversed {
    transform: scale(-1, 1);
    transform-origin: center;
}
path {
    fill: #ebebeb;
    stroke: #000;
    stroke-width: 4px;
}
image {
    transform-box: fill-box;
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
g.arm {
    animation: animatearms infinite ease-in-out alternate;
}
g#arm_front {
    transform-origin: 28% 39%;
}
g#arm_back {
    transform-origin: 28% 39%;
}
g#head path {
    fill: url(#img1);
}
</style>
