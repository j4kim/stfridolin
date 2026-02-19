<script setup lang="ts">
import "vue-sonner/style.css";
import { Toaster } from "@/components/ui/sonner";
</script>

<template>
    <slot></slot>
    <Toaster richColors />
</template>
