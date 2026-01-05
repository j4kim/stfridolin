<script setup>
import { useMainStore } from "@/stores/main";

const mainStore = useMainStore();
</script>

<template>
    <template v-if="mainStore.user">
        <slot></slot>
    </template>
</template>
