import { defineStore } from "pinia";
import { ref, watch } from "vue";
import { api } from "@/api";
import { useGuestStore } from "./guest";

export const useGamesStore = defineStore("games", () => {
    const guestStore = useGuestStore();

    const gameName = ref(null);

    const game = ref(null);

    const occurrence = ref(null);

    const fetching = ref(false);
    const betting = ref(false);

    async function fetchGame() {
        if (!gameName.value) {
            throw new Error("No gameName");
        }
        fetching.value = true;
        try {
            game.value = await api("games.get").params(gameName.value).get();
        } finally {
            fetching.value = false;
        }
    }

    async function fetchOccurrence(occurrenceId) {
        if (occurrence.value && occurrenceId != occurrence.value.id) {
            occurrence.value = null;
        }
        fetching.value = true;
        occurrence.value = await api("occurrences.get")
            .params(occurrenceId)
            .get()
            .finally(() => (fetching.value = false));
    }

    async function betOn(competitor, articleName) {
        betting.value = true;
        const result = await api("occurrences.bet")
            .params({
                occurrence: occurrence.value.id,
                competitor: competitor.id,
                articleName,
            })
            .post()
            .finally(() => (betting.value = false));
        guestStore.movements.unshift(result.movement);
        return result;
    }

    async function openRace() {
        const result = await api("occurrences.open")
            .params({ occurrence: occurrence.value.id })
            .post();
        await fetchOccurrence(occurrence.value.id);
        return result;
    }

    async function startRace() {
        const result = await api("occurrences.start")
            .params({ occurrence: occurrence.value.id })
            .post();
        await fetchOccurrence(occurrence.value.id);
        return result;
    }

    async function setRanking(ranking) {
        const result = await api("occurrences.setRanking")
            .params({ occurrence: occurrence.value.id })
            .data({ ranking })
            .post();
        await fetchOccurrence(occurrence.value.id);
        return result;
    }

    watch(gameName, (newGameName, oldGameName) => {
        console.log("gameName changed from", oldGameName, "to", newGameName);
    });

    return {
        game,
        gameName,
        occurrence,
        fetching,
        fetchGame,
        fetchOccurrence,
        betOn,
        betting,
        openRace,
        startRace,
        setRanking,
    };
});
