<script setup>
import { onMounted } from "vue";

defineProps({
    items: Array,
});

onMounted(() => {
    document.documentElement.classList.remove("dark");
});
</script>

<template>
    <header class="flex gap-4 p-4 print:hidden">
        <a href="/" class="link">Home</a>
        <a href="/admin" class="link">Admin panel</a>
    </header>
    <div class="flex flex-wrap">
        <div v-for="item in items" class="card-container">
            <div class="card flex flex-col justify-center p-[5mm]">
                <img class="mx-auto mb-[2mm] w-[10mm]" src="/favicon.svg" />
                <slot name="item" v-bind="item"></slot>
            </div>
            <template v-for="x in ['left', 'right']">
                <div
                    v-for="y in ['top', 'bottom']"
                    class="cut-line"
                    :style="{
                        [x]: 0,
                        [y]: 0,
                    }"
                >
                    <div class="horizontal" :class="`${x} ${y}`"></div>
                    <div class="vertical" :class="`${x} ${y}`"></div>
                </div>
            </template>
        </div>
    </div>
</template>

<style scoped lang="scss">
@page {
    margin: 6mm;
}
.card-container {
    --width: 55mm;
    --height: 85mm;
    --margin: 5mm;
    break-inside: avoid;
    position: relative;
}
.card {
    width: var(--width);
    height: var(--height);
    margin: var(--margin);
}
.cut-line {
    height: var(--margin);
    width: var(--margin);
    position: absolute;
    --length: 2mm;
    div {
        position: absolute;
        background-color: grey;
        height: 0.1mm;
        width: 0.1mm;
        &.horizontal {
            width: var(--length);
            left: calc((var(--margin) - var(--length)) / 2);
            &.top {
                bottom: 0;
            }
        }
        &.vertical {
            height: var(--length);
            top: calc((var(--margin) - var(--length)) / 2);
            &.left {
                right: 0;
            }
        }
    }
}
</style>
