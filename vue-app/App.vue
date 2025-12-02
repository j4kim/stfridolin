<script setup>
import { useMainStore } from "./stores/main";

const mainStore = useMainStore();
</script>

<template>
    <h1 class="p-2 text-2xl">
        <RouterLink to="/">
            {{ mainStore.appName }}
        </RouterLink>
    </h1>
    <nav class="flex gap-4 p-2">
        <RouterLink :to="{ name: 'home' }" activeClass="font-bold">
            Home
        </RouterLink>
        <RouterLink :to="{ name: 'spotify' }" activeClass="font-bold">
            Spotify remote
        </RouterLink>
        <RouterLink :to="{ name: 'boxers' }" activeClass="font-bold">
            Boxers
        </RouterLink>
    </nav>
    <main class="p-2">
        <RouterView></RouterView>
    </main>
    <footer class="p-2 text-sm opacity-50">v{{ mainStore.appVersion }}</footer>
</template>
