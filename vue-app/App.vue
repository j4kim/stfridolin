<script setup lang="ts">
import { defineAsyncComponent } from "vue";
import { useMainStore } from "./stores/main";

const mainStore = useMainStore();

const UseToaster = defineAsyncComponent(
    () => import("@/components/UseToaster.vue"),
);
</script>

<template>
    <UseToaster>
        <div v-if="mainStore.navigating">loading</div>
        <RouterView v-else></RouterView>
    </UseToaster>
</template>
