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
import { useGuestStore } from "@/stores/guest";
import { useMainStore } from "@/stores/main";
import {
    CircleStar,
    HandFist,
    Home,
    ListMusic,
    ListPlus,
    Play,
    TvMinimalPlay,
    User,
} from "lucide-vue-next";
import { computed } from "vue";
import { useRoute } from "vue-router";

const mainStore = useMainStore();

const guestStore = useGuestStore();

const groups = computed(() => [
    {
        label: "St-Fridolin",
        links: [
            {
                title: "Accueil",
                to: { name: "home" },
                icon: Home,
            },
            {
                title: "Profil",
                to: guestStore.guest.id
                    ? {
                          name: "guest-page",
                          params: { key: guestStore.guest.key },
                      }
                    : { name: "guest-auth-form" },
                icon: User,
            },
            {
                title: "Acheter des jetons",
                to: { name: "buy-tokens" },
                icon: CircleStar,
            },
        ],
    },
    {
        label: "Jeux",
        links: [
            {
                title: "Jukeboxe",
                to: { name: "vote" },
                icon: HandFist,
            },
        ],
    },
    {
        label: "Admin",
        requiresAuth: true,
        links: [
            {
                title: "Combat",
                to: { name: "boxing" },
                icon: TvMinimalPlay,
            },
            {
                title: "Spotify",
                to: { name: "spotify" },
                icon: Play,
            },
        ],
    },
]);

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
                                        :is-active="route.name === link.to.name"
                                    >
                                        <RouterLink :to="link.to">
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
