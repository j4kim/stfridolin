<script setup>
import { Card, CardContent, CardHeader } from "@/components/ui/card";
import AnimatedCount from "./AnimatedCount.vue";
import {
    Drawer,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from "./ui/drawer";
import { ref } from "vue";
import { Button } from "./ui/button";

defineProps({
    header: String,
    value: Number,
    icon: Function,
    description: String,
});

const open = ref(false);
</script>

<template>
    <Drawer v-model:open="open">
        <DrawerTrigger as-child>
            <Card class="w-full">
                <CardHeader class="flex">
                    <component :is="icon" />
                    {{ header }}
                </CardHeader>
                <CardContent class="text-3xl font-bold">
                    <AnimatedCount :value="value" />
                </CardContent>
            </Card>
        </DrawerTrigger>
        <DrawerContent>
            <DrawerHeader>
                <DrawerTitle class="flex gap-2">
                    <component :is="icon" />
                    {{ header }}
                </DrawerTitle>
            </DrawerHeader>
            <div class="px-4">
                <p class="text-lg">
                    Vous avez
                    <span class="font-bold">{{ value }} {{ header }}</span>
                </p>
                <DrawerDescription>
                    {{ description }}
                </DrawerDescription>
            </div>
            <DrawerFooter>
                <slot name="drawerFooter"></slot>
            </DrawerFooter>
        </DrawerContent>
    </Drawer>
</template>
