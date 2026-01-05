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
import { useRoute } from "vue-router";

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
            <SidebarGroup v-for="group in groups">
                <SidebarGroupLabel>{{ group.label }}</SidebarGroupLabel>
                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem
                            v-for="link in group.links"
                            :key="link.title"
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
                    </SidebarMenu>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>
