<script setup>
import titleSvg from "@/title.svg";
</script>

<template>
    <div class="mx-auto max-w-xl p-8">
        <RouterLink :to="{ name: 'home' }">
            <img class="mx-auto my-12 w-sm hover:opacity-80" :src="titleSvg" />
        </RouterLink>
        <slot></slot>
    </div>
</template>
