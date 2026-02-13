<script setup>
import titleSvg from "@/title.svg";
</script>

<template>
    <div class="mx-auto max-w-xl p-8">
        <img class="mx-auto max-w-xl p-12" :src="titleSvg" />
        <slot></slot>
    </div>
</template>
