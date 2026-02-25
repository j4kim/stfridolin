<script setup>
import { useMainStore } from "@/stores/main";

const mainStore = useMainStore();
</script>

<template>
    <slot v-if="mainStore.user"></slot>
    <slot v-else name="else"></slot>
</template>
