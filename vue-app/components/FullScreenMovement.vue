<script setup>
import dayjs from "dayjs";
import { computed } from "vue";
import Button from "./ui/button/Button.vue";
import { useGuestStore } from "@/stores/guest";
import { icon, tr } from "@/translate";

const props = defineProps({
    movement: Object,
});

const emits = defineEmits(["close"]);

const guestStore = useGuestStore();

const createdAt = computed(() =>
    dayjs(props.movement.created_at).format("DD.MM.YYYY HH:mm:ss"),
);

const currency = computed(() => {
    return ["tokens", "points"].find((c) => !!props.movement[c]);
});
</script>

<template>
    <div
        class="flex h-dvh flex-col justify-between p-8"
        :class="{
            'bg-emerald-600': currency === 'tokens',
            'bg-purple-600': currency === 'points',
        }"
    >
        <div class="flex grow flex-col items-center justify-center gap-4">
            <div
                class="mb-4 flex flex-col items-center gap-4 text-center text-5xl font-extrabold"
            >
                <component
                    :is="icon(currency)"
                    class="h-[1.2em] w-[1.2em] animate-bounce"
                />
                {{ movement[currency] }} {{ tr(currency) }}
            </div>
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
