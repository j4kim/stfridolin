<script setup>
import { useBoxingStore } from "@/stores/boxing";
import { onMounted, ref } from "vue";

const right = ref(false);
const t0 = ref(null);

function toggle(winnerSide, t = 550) {
    right.value = !right.value;
    if (t > 0) {
        setTimeout(() => toggle(winnerSide, t - 50), t);
    } else {
        right.value = winnerSide === "right";
    }
}

onMounted(() => {
    const boxing = useBoxingStore();
    t0.value = Date.now();
    toggle(boxing.tossAnimation);
});
</script>

<template>
    <div
        class="absolute top-0 flex h-full w-full flex-col items-center justify-center font-black text-shadow-lg"
    >
        <div class="mt-[4cqw] text-[4cqw]">Tirage au sort</div>
        <div class="arrow text-[6cqw]" :class="{ right }">←</div>
    </div>
</template>

<style scoped>
.arrow.right {
    transform: scaleX(-1);
}
</style>
