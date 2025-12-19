<script setup>
import Button from "@/components/ui/button/Button.vue";
import { useSpotifyStore } from "@/stores/spotify";

const spotify = useSpotifyStore();
spotify.getDevices();
</script>

<template>
    <ul class="flex flex-col gap-2">
        <li v-for="device in spotify.devices" class="flex items-center gap-2">
            <span class="font-semibold">{{ device.name }}</span>
            <span>{{ device.is_active ? "active" : "inactive" }}</span>
            <Button
                size="sm"
                :disabled="device.selected"
                @click="spotify.selectDevice(device.id)"
                v-text="device.selected ? 'selected' : 'select'"
            ></Button>
        </li>
    </ul>
</template>
