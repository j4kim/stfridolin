<script setup lang="ts">
import { defineAsyncComponent } from "vue";

const UseToaster = defineAsyncComponent(
    () => import("@/components/UseToaster.vue"),
);
</script>

<template>
    <UseToaster>
        <RouterView></RouterView>
    </UseToaster>
</template>
