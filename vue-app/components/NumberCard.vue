<script setup>
import { Card, CardContent, CardHeader } from "@/components/ui/card";
import AnimatedCount from "./AnimatedCount.vue";

defineProps({
    header: String,
    value: Number,
    icon: Function,
});
</script>

<template>
    <Card class="w-full">
        <CardHeader class="flex">
            <component :is="icon" />
            {{ header }}
        </CardHeader>
        <CardContent class="text-3xl font-bold">
            <AnimatedCount :value="value" />
        </CardContent>
    </Card>
</template>
