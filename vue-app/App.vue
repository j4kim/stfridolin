<script setup lang="ts">
import { defineAsyncComponent } from "vue";
import { useMainStore } from "./stores/main";
import FullPageLoading from "./views/FullPageLoading.vue";

const mainStore = useMainStore();

const UseToaster = defineAsyncComponent(
    () => import("@/components/UseToaster.vue"),
);
</script>

<template>
    <UseToaster>
        <FullPageLoading v-if="mainStore.navigating" />
        <RouterView v-else></RouterView>
    </UseToaster>
</template>
