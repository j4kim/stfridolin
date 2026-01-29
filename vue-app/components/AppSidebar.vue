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
import {
    HandFist,
    Home,
    ListMusic,
    ListPlus,
    Play,
    TvMinimalPlay,
} from "lucide-vue-next";
import { useRoute } from "vue-router";

const mainStore = useMainStore();

const groups = [
    {
        label: "St-Fridolin",
        links: [
            {
                title: "Accueil",
                name: "home",
                icon: Home,
            },
        ],
    },
    {
        label: "Jukeboxe",
        links: [
            {
                title: "Voter",
                name: "vote",
                icon: HandFist,
            },
            {
                title: "File d'attente",
                name: "queue",
                icon: ListMusic,
            },
            {
                title: "Ajouter",
                name: "add-to-queue",
                icon: ListPlus,
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
                icon: TvMinimalPlay,
            },
            {
                title: "Spotify",
                name: "spotify",
                icon: Play,
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
                                            <component
                                                v-if="link.icon"
                                                :is="link.icon"
                                            />
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
