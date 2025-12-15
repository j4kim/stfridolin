<script setup>
import Boxers from "../boxing/Boxers.vue";
import ring from "../boxing/svg/ring.svg";
import BoxingControls from "../boxing/BoxingControls.vue";
</script>

<template>
    <div
        class="flex aspect-video flex-col"
        :style="{
            backgroundImage: `url(${ring})`,
        }"
    >
        <div class="aspect-240/35"></div>
        <div class="flex grow">
            <div class="grow text-center text-[2vw]">Track left</div>
            <div class="aspect-3/2 h-full"><Boxers /></div>
            <div class="grow text-center text-[2vw]">Track right</div>
        </div>
    </div>
    <BoxingControls class="mt-2" />
</template>
