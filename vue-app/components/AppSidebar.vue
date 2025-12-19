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

const groups = [
    {
        label: "Jukeboxe",
        links: [
            {
                title: "Voter",
                name: "vote",
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
                            <SidebarMenuButton as-child>
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
