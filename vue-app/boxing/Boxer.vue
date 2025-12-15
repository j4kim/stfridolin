<script setup>
import { onMounted } from "vue";

const max = 1.1;
const min = 0.7;
const animBackArmDuration = Math.random() * (max - min) + min;
const animFrontArmDuration = Math.random() * (max - min) + min;

const props = defineProps({
    fighter: Object,
});

onMounted(() => {
    props.fighter.initTimelines();
});
</script>

<template>
    <g
        :id="fighter.id"
        v-html="fighter.initialSvgContent"
        :style="{
            '--animBackArmDuration': `${animBackArmDuration}s`,
            '--animFrontArmDuration': `${animFrontArmDuration}s`,
        }"
        class="boxer"
        :class="{ ko: fighter.ko }"
    ></g>
</template>

<style>
@keyframes animatearms {
    0% {
        rotate: 0deg;
    }
    100% {
        rotate: 10deg;
    }
}
.boxer g[data-name^="arm_"] {
    transform-origin: var(--armTransformOriginX) 39%;
    animation: animatearms infinite ease-in-out alternate;
}
.boxer.ko g[data-name^="arm_"] {
    animation: none;
}
.boxer#left {
    --armTransformOriginX: 28%;
}
.boxer#right {
    --armTransformOriginX: 72%;
}
.boxer g[data-name="arm_back"] {
    animation-duration: var(--animBackArmDuration);
}
.boxer g[data-name="arm_front"] {
    animation-duration: var(--animFrontArmDuration);
}
</style>
