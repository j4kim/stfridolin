<script setup>
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
        <div class="p-2">
            <Button @click="enter">Plein écran</Button>
        </div>
    </Layout>
</template>
