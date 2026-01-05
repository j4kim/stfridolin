<script setup>
import Controls from "@/boxing/Controls.vue";
import Ring from "@/boxing/Ring.vue";
import Layout from "@/components/Layout.vue";
import SetAsMasterButton from "@/components/SetAsMasterButton.vue";
import { Button } from "@/components/ui/button";
import { useFullscreen, useWakeLock } from "@vueuse/core";
import { onMounted, onUnmounted, useTemplateRef } from "vue";

const ring = useTemplateRef("ring");
const { isFullscreen, enter } = useFullscreen(ring);

const { request, release, isActive, isSupported } = useWakeLock();

onMounted(async () => {
    if (isSupported.value) {
        await request();
        console.log("wake lock active:", isActive.value);
    } else {
        console.warn("wake lock is not supported");
    }
});

onUnmounted(async () => {
    if (isActive.value) {
        await release();
        console.log("wake lock released");
    }
});
</script>

<template>
    <Layout>
        <Ring ref="ring" :class="{ 'cursor-none': isFullscreen }" />
        <div class="m-2 flex gap-2">
            <Button size="sm" @click="enter">Plein écran</Button>
            <SetAsMasterButton />
        </div>
        <Controls class="m-2"></Controls>
    </Layout>
</template>
