<script setup>
import PublicLayout from "@/components/PublicLayout.vue";
import { ref, watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const html = ref("");

async function loadContent(pageName) {
    html.value = "Chargement...";
    const mod = await import(`../pages/${pageName}.html?raw`);
    html.value = mod.default;
}

watch(route, (r) => loadContent(r.params.page), { immediate: true });
</script>

<template>
    <PublicLayout>
        <div
            class="prose lg:prose-lg dark:prose-invert text-white"
            v-html="html"
        ></div>
    </PublicLayout>
</template>
