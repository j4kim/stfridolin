<script setup>
import { CircleStar, Ticket } from "lucide-vue-next";
import { Button } from "./ui/button";
import { useGuestStore } from "@/stores/guest";

const guestStore = useGuestStore();
</script>

<template>
    <RouterLink
        v-if="guestStore.guest.id"
        :to="{ name: 'guest-page', params: { key: guestStore.guest.key } }"
    >
        <Button size="sm" class="rounded-full" variant="outline">
            {{ guestStore.guest.tokens }} <CircleStar />
            <span class="opacity-50">/</span>
            {{ guestStore.guest.points }} <Ticket />
        </Button>
    </RouterLink>
</template>
