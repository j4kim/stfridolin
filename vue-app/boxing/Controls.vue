<script setup>
import { post } from "@/api";
import Button from "@/components/ui/button/Button.vue";
import { useFightStore } from "@/stores/fight";

const fightStore = useFightStore();

async function vote(side) {
    const fight = fightStore.fight;
    if (!fight) {
        throw new Error("There is no fight");
    }
    const track = fight[`${side}_track`];
    return await post("votes.vote", [fight.id, track.id]);
}
</script>

<template>
    <div class="flex gap-2">
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
    </div>
</template>
