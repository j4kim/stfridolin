import { defineStore } from "pinia";
import { ref } from "vue";
import { get } from "@/api";

export const useFightStore = defineStore("fight", () => {
    const fight = ref(null);

    async function fetchCurrentFight() {
        fight.value = await get("fights.current");
    }

    async function endFight() {
        const leftVotes = fight.value.left_track.votes_count;
        const rightVotes = fight.value.right_track.votes_count;
        console.log({ leftVotes, rightVotes });
    }

    return {
        fight,
        fetchCurrentFight,
        endFight,
    };
});
