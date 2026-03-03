<script setup>
import { computed, onMounted, ref } from "vue";
import { chunk } from "lodash-es";

const props = defineProps({
    items: Array,
});

onMounted(() => {
    document.documentElement.classList.remove("dark");
});

const chunkSize = ref(21);

const chunks = computed(() => chunk(props.items, chunkSize.value));
</script>

<template>
    <header class="flex gap-4 p-4 print:hidden">
        <a href="/" class="link">Home</a>
        <a href="/admin" class="link">Admin panel</a>
    </header>
    <div class="p-4 print:hidden">
        <slot name="below-header" v-bind="items"></slot>

        <div>Cartes par page: <input type="number" v-model="chunkSize" /></div>
    </div>
    <div v-for="chunkItems in chunks" class="cards-container flex flex-wrap">
        <div v-for="item in chunkItems" class="card-container">
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
.cards-container {
    --margin: 5mm;
    padding: var(--margin);
    break-inside: avoid;
}
.card-container {
    --width: 55mm;
    --height: 85mm;
    break-inside: avoid;
    position: relative;
    margin: calc(-1 * var(--margin));
}
.card {
    width: var(--width);
    height: var(--height);
    margin: var(--margin);
    background-color: white;
    position: relative;
    z-index: 1;
    outline: 1.5mm solid white;
}
.cut-line {
    height: var(--margin);
    width: var(--margin);
    position: absolute;
    --length: 2mm;
    z-index: 0;
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
