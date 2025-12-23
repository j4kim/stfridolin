<script setup>
import Controls from "@/boxing/Controls.vue";
import Ring from "@/boxing/Ring.vue";
import Layout from "@/components/Layout.vue";
import { Button } from "@/components/ui/button";
import { useFullscreen } from "@vueuse/core";
import { useTemplateRef } from "vue";

const ring = useTemplateRef("ring");
const { isFullscreen, enter } = useFullscreen(ring);
</script>

<template>
    <Layout>
        <Ring ref="ring" :class="{ 'cursor-none': isFullscreen }" />
        <div class="m-2">
            <Button size="sm" @click="enter">Plein écran</Button>
        </div>
        <Controls class="m-2"></Controls>
    </Layout>
</template>
