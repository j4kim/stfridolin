<script setup>
import { api } from "@/api";
import Controls from "@/boxing/Controls.vue";
import Ring from "@/boxing/Ring.vue";
import Layout from "@/components/Layout.vue";
import SetAsMasterButton from "@/components/SetAsMasterButton.vue";
import { Button } from "@/components/ui/button";
import { useFullscreen, useWakeLock } from "@vueuse/core";
import { onMounted, onUnmounted, ref, useTemplateRef } from "vue";

const screen = useTemplateRef("screen");
const { isFullscreen, enter } = useFullscreen(screen);

const { request, release, isActive, isSupported } = useWakeLock();

onMounted(async () => {
    if (isSupported.value) {
        await request();
    }
});

onUnmounted(async () => {
    if (isActive.value) {
        await release();
    }
});

const sponsors = ref([]);

api("sponsors.index")
    .get()
    .then((data) => (sponsors.value = data));
</script>

<template>
    <Layout>
        <div
            ref="screen"
            :class="{ 'cursor-none': isFullscreen }"
            class="flex flex-col items-center gap-12 p-4"
        >
            <h1 class="text-4xl font-bold italic">Merci à nos sponsors !</h1>
            <div class="flex flex-wrap content-center items-center gap-12">
                <div
                    v-for="sponsor in sponsors"
                    class="flex flex-col items-center gap-4"
                >
                    <img :src="sponsor.logo_url" class="max-h-60 max-w-60" />
                    <div class="text-xl">{{ sponsor.name }}</div>
                </div>
            </div>
        </div>
        <div class="m-2 flex gap-2">
            <Button size="sm" @click="enter">Plein écran</Button>
        </div>
    </Layout>
</template>
