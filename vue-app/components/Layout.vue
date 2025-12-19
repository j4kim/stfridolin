<script setup>
import AppSidebar from "./AppSidebar.vue";
import { SidebarProvider, SidebarTrigger } from "./ui/sidebar";
import { useMainStore } from "@/stores/main";

const mainStore = useMainStore();
</script>

<template>
    <SidebarProvider>
        <AppSidebar />
        <main class="grow">
            <header class="bg-sidebar flex items-center gap-2 p-2">
                <SidebarTrigger />
                <h1 class="font-bold tracking-widest uppercase">
                    {{ mainStore.appName }}
                </h1>
            </header>
            <slot />
        </main>
    </SidebarProvider>
</template>
