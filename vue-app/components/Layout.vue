<script setup>
import AppSidebar from "./AppSidebar.vue";
import GuestStatus from "./GuestStatus.vue";
import { SidebarProvider, SidebarTrigger } from "./ui/sidebar";
import { useMainStore } from "@/stores/main";

const mainStore = useMainStore();

defineProps({
    simple: Boolean
})
</script>

<template>
    <component :is="simple ? 'div' : SidebarProvider">
        <AppSidebar v-if="!simple"/>
        <main class="grow">
            <header class="bg-sidebar flex items-center gap-2 px-2 h-10">
                <SidebarTrigger v-if="!simple"/>
                <h1 class="font-bold tracking-widest uppercase">
                    <RouterLink :to="{name: 'home'}">
                        {{ mainStore.appName }}
                    </RouterLink>
                </h1>
                <div class="grow"></div>
                <GuestStatus/>
            </header>
            <slot />
        </main>
    </component :is="simple ? 'div' : SidebarProvider">
</template>
