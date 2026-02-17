<script setup lang="ts">
import { defineAsyncComponent } from "vue";

const Spinner = defineAsyncComponent(
    () => import("@/components/ui/spinner/Spinner.vue"),
);
</script>

<template>
    <div class="flex h-dvh flex-col items-center justify-center gap-2">
        <Spinner class="size-10" />
        <div>Chargement</div>
    </div>
</template>
