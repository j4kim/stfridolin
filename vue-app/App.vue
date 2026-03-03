<script setup lang="ts">
import { defineAsyncComponent } from "vue";
import { useMainStore } from "./stores/main";
import FullPageLoading from "./components/FullPageLoading.vue";

const mainStore = useMainStore();

const UseToaster = defineAsyncComponent({
    loader: () => import("@/components/UseToaster.vue"),
    loadingComponent: FullPageLoading,
    delay: 100,
});
</script>

<template>
    <UseToaster>
        <FullPageLoading v-if="mainStore.isNavigating" />
        <RouterView v-else></RouterView>
    </UseToaster>
</template>
