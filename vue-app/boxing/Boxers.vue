<script setup>
import SvgBoxer from "./SvgBoxer.vue";
import { useBoxingStore } from "../stores/boxing";

const boxingStore = useBoxingStore();
</script>

<template>
    <div class="relative h-full w-full">
        <Transition>
            <div v-if="boxingStore.running">
                <SvgBoxer v-for="fighter in boxingStore.fighters" :fighter />
            </div>
        </Transition>
    </div>
</template>

<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
