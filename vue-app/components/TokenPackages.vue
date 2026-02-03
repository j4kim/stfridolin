<script setup>
import { Badge, CircleStar } from "lucide-vue-next";
import { Card } from "./ui/card";

defineProps({
    articles: Array,
});

defineEmits(["select"]);
</script>

<template>
    <div class="grid grid-cols-2 gap-4 px-4">
        <Card
            class="relative gap-2 p-4"
            v-for="p in articles"
            @click="() => $emit('select', p)"
        >
            <div class="flex items-center gap-1">
                {{ p.description }}
                <CircleStar size="18" />
            </div>
            <div v-if="!p.discount">
                <span class="text-2xl font-bold">{{ p.price }}</span>
                <span class="text-xs"> CHF</span>
            </div>
            <div v-else>
                <span class="text-xs line-through opacity-50">
                    {{ p.std_price }} CHF
                </span>
                <div>
                    <span class="text-2xl font-bold">{{ p.price }}</span>
                    <span class="text-xs"> CHF</span>
                </div>
                <div class="absolute -right-3 bottom-4 w-13 rotate-10">
                    <Badge
                        :class="
                            p.discount > 50
                                ? 'text-fuchsia-500'
                                : 'text-sky-500'
                        "
                        fill="currentColor"
                        size="100%"
                    />
                    <div
                        class="absolute top-0 flex h-full w-full items-center justify-center text-sm font-extrabold"
                    >
                        -{{ p.discount }}%
                    </div>
                </div>
            </div>
        </Card>
    </div>
</template>
