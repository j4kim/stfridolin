<script setup>
import { CircleStar, Gift } from "lucide-vue-next";
import { Button } from "./ui/button";
import { useGuestStore } from "@/stores/guest";
import AnimatedCount from "./AnimatedCount.vue";

const guestStore = useGuestStore();
</script>

<template>
    <RouterLink
        v-if="guestStore.guest.id"
        :to="{ name: 'guest-page', params: { key: guestStore.guest.key } }"
    >
        <Button size="sm" class="h-7 rounded-full text-xs" variant="outline">
            <AnimatedCount :value="guestStore.guest.tokens" /> <CircleStar />
            <span class="opacity-50">/</span>
            <AnimatedCount :value="guestStore.guest.points" /> <Gift />
        </Button>
    </RouterLink>
</template>
