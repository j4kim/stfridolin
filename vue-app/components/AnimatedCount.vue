<script setup>
import { CountUp } from "countup.js";
import { onMounted, useTemplateRef, watch } from "vue";

const props = defineProps({ value: Number, startVal: Number });

const countEl = useTemplateRef("counter");

let countUp = null;

watch(
    () => props.value,
    (newValue) => {
        countUp?.update(newValue);
    },
);

onMounted(() => {
    countUp = new CountUp(countEl.value, props.value, {
        startVal: props.startVal ?? props.value,
        duration: 1.5,
        separator: "’",
    });
    countUp.start();
});
</script>

<template>
    <span ref="counter">{{ value }}</span>
</template>
