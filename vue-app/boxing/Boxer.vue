<script setup>
import { onMounted } from "vue";

const max = 1.1;
const min = 0.7;
const animBackArmDuration = Math.random() * (max - min) + min;
const animFrontArmDuration = Math.random() * (max - min) + min;

const props = defineProps({
    imageUrl: String,
    reversed: Boolean,
    initialSvgContent: String,
    fighter: Object,
});

onMounted(() => {
    props.fighter.mount();
});
</script>

<template>
    <g
        :id="fighter.id"
        :class="{ reversed }"
        v-html="initialSvgContent"
        :style="{
            '--animBackArmDuration': `${animBackArmDuration}s`,
            '--animFrontArmDuration': `${animFrontArmDuration}s`,
        }"
        @click="fighter.punch"
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
