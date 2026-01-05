<script setup>
import {
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarGroupContent,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from "@/components/ui/sidebar";
import { useMainStore } from "@/stores/main";
import { useRoute } from "vue-router";

const mainStore = useMainStore();

const groups = [
    {
        label: "Jukeboxe",
        links: [
            {
                title: "Voter",
                name: "vote",
            },
            {
                title: "File d'attente",
                name: "queue",
            },
            {
                title: "Ajouter",
                name: "add-to-queue",
            },
        ],
    },
    {
        label: "Admin",
        requiresAuth: true,
        links: [
            {
                title: "Combat",
                name: "boxing",
            },
            {
                title: "Spotify",
                name: "spotify",
            },
        ],
    },
];

const route = useRoute();
</script>

<template>
    <Sidebar>
        <SidebarContent>
            <template v-for="group in groups">
                <SidebarGroup v-if="!group.requiresAuth || mainStore.user">
                    <SidebarGroupLabel>{{ group.label }}</SidebarGroupLabel>
                    <SidebarGroupContent>
                        <SidebarMenu>
                            <template
                                v-for="link in group.links"
                                :key="link.title"
                            >
                                <SidebarMenuItem
                                    v-if="!group.requiresAuth || mainStore.user"
                                >
                                    <SidebarMenuButton
                                        as-child
                                        :is-active="route.name === link.name"
                                    >
                                        <RouterLink :to="{ name: link.name }">
                                            <span>{{ link.title }}</span>
                                        </RouterLink>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                            </template>
                        </SidebarMenu>
                    </SidebarGroupContent>
                </SidebarGroup>
            </template>
        </SidebarContent>
    </Sidebar>
</template>
