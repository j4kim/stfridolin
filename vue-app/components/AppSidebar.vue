<script setup>
import {
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarGroupContent,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuItem,
} from "@/components/ui/sidebar";
import { useGuestStore } from "@/stores/guest";
import { useMainStore } from "@/stores/main";
import {
    CirclePile,
    CircleStar,
    HandFist,
    HatGlasses,
    Home,
    Play,
    QrCode,
    Settings,
    Trophy,
    TvMinimalPlay,
    User,
    Weight,
} from "lucide-vue-next";
import { computed } from "vue";
import AppSidebarLink from "./AppSidebarLink.vue";

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
                title: "Courses de billes",
                to: {
                    name: "race-index",
                    params: { gameName: "marble-race" },
                },
                icon: CirclePile,
            },
            {
                title: "Jukeboxe",
                to: { name: "vote" },
                icon: HandFist,
            },
            {
                title: "Poids de Joe",
                to: { name: "joes-weight" },
                icon: Weight,
            },
            {
                title: "Concours hippique",
                to: {
                    name: "race-index",
                    params: { gameName: "horse-show" },
                },
                icon: Trophy,
            },
            {
                title: "Où est Joe ?",
                to: {
                    name: "race-index",
                    params: { gameName: "where-is-joe" },
                },
                icon: HatGlasses,
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
            {
                title: "Scan",
                to: { name: "qr-scan" },
                icon: QrCode,
            },
            {
                title: "Admin panel",
                to: "/admin",
                icon: Settings,
                external: true,
            },
        ],
    },
]);
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
                                    <AppSidebarLink
                                        :to="link.to"
                                        :external="link.external"
                                    >
                                        <component
                                            v-if="link.icon"
                                            :is="link.icon"
                                        />
                                        <span>{{ link.title }}</span>
                                    </AppSidebarLink>
                                </SidebarMenuItem>
                            </template>
                        </SidebarMenu>
                    </SidebarGroupContent>
                </SidebarGroup>
            </template>
        </SidebarContent>
        <span class="p-2 text-[10px] opacity-40">
            v{{ mainStore.pkgVersion }}
        </span>
    </Sidebar>
</template>
