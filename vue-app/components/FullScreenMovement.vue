<script setup>
import dayjs from "dayjs";
import { computed } from "vue";
import Button from "./ui/button/Button.vue";
import { useGuestStore } from "@/stores/guest";
import { tr } from "@/translate";

const props = defineProps({
    movement: Object,
});

const emits = defineEmits(["close"]);

const guestStore = useGuestStore();

const createdAt = computed(() =>
    dayjs(props.movement.created_at).format("DD.MM.YYYY HH:mm:ss"),
);
</script>

<template>
    <div class="flex h-dvh flex-col justify-between bg-emerald-600 p-8">
        <div class="flex grow flex-col items-center justify-center gap-4">
            <template v-for="currency in ['tokens', 'points']">
                <div v-if="movement[currency]" class="mb-4 text-4xl font-bold">
                    {{ movement[currency] }} {{ tr(currency) }}
                </div>
            </template>
            <div class="text-2xl">{{ guestStore.guest.name }}</div>
            <div class="tabular-nums">{{ createdAt }}</div>
        </div>
        <RouterLink
            :to="{ name: 'guest-page', params: { key: guestStore.guest.key } }"
        >
            <Button class="w-full" variant="outline" size="lg"> Fermer </Button>
        </RouterLink>
    </div>
</template>
