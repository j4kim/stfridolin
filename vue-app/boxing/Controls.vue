<script setup>
import { api } from "@/api";
import Button from "@/components/ui/button/Button.vue";
import { useFightStore } from "@/stores/fight";
import { useSpotifyStore } from "@/stores/spotify";
import { Pause, Play } from "lucide-vue-next";

const fightStore = useFightStore();
const spotify = useSpotifyStore();

async function vote(side) {
    const fight = fightStore.fight;
    if (!fight) {
        throw new Error("There is no fight");
    }
    const track = fight[`${side}_track`];
    return await api("votes.vote").params([fight.id, track.id]).post();
}
</script>

<template>
    <div class="flex flex-wrap gap-2">
        <Button size="sm" variant="outline" @click="vote('left')">
            Vote left
        </Button>
        <Button size="sm" variant="outline" @click="vote('right')">
            Vote right
        </Button>
        <Button size="sm" variant="outline" @click="fightStore.endFight">
            End fight
        </Button>
        <Button size="sm" variant="outline" @click="fightStore.createNext">
            Create next
        </Button>
        <Button size="sm" variant="outline" @click="spotify.skipToNext">
            Skip to next track
        </Button>
        <Button size="sm" variant="outline" @click="spotify.toggle">
            <component :is="spotify.playback?.is_playing ? Pause : Play" />
            {{ spotify.playback?.is_playing ? "Pause" : "Play" }}
        </Button>
    </div>
</template>
