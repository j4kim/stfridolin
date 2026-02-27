import { defineStore } from "pinia";
import { computed, ref, watch } from "vue";
import { keyBy } from "lodash-es";
import { api } from "@/api";
import { useGuestStore } from "./guest";

export const useGamesStore = defineStore("games", () => {
    const guestStore = useGuestStore();

    const games = ref([]);

    const gameName = ref(null);

    const occurrence = ref(null);

    const fetching = ref(false);
    const betting = ref(false);

    async function fetchGames() {
        fetching.value = true;
        try {
            games.value = await api("games.index").get();
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

    const byName = computed(() => keyBy(games.value, "name"));

    const marbleRace = computed(() => byName.value["marble-race"]);

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
        await fetchGames();
        return result;
    }

    async function startRace() {
        const result = await api("occurrences.start")
            .params({ occurrence: occurrence.value.id })
            .post();
        await fetchGames();
        return result;
    }

    async function setRanking(ranking) {
        const result = await api("occurrences.setRanking")
            .params({ occurrence: occurrence.value.id })
            .data({ ranking })
            .post();
        await fetchGames();
        return result;
    }

    watch(gameName, (newGameName, oldGameName) => {
        console.log("gameName changed from", oldGameName, "to", newGameName);
    });

    return {
        games,
        gameName,
        occurrence,
        fetching,
        fetchGames,
        fetchOccurrence,
        byName,
        marbleRace,
        betOn,
        betting,
        openRace,
        startRace,
        setRanking,
    };
});
