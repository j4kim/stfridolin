import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { keyBy } from "lodash-es";
import { api } from "@/api";
import { useGuestStore } from "./guest";

export const useGamesStore = defineStore("games", () => {
    const guestStore = useGuestStore();

    const games = ref([]);
    const fetchingGames = ref(false);
    const betting = ref(false);

    async function fetchGames() {
        fetchingGames.value = true;
        try {
            games.value = await api("games.index").get();
        } finally {
            fetchingGames.value = false;
        }
    }

    async function fetchGamesIfNeeded() {
        if (games.value.length) return;
        await fetchGames();
    }

    const byName = computed(() => keyBy(games.value, "name"));

    const marbleRace = computed(() => byName.value["marble-race"]);

    async function betOn(competitor, articleName) {
        betting.value = true;
        const result = await api("occurrences.bet")
            .params({
                occurrence: competitor.pivot.occurrence_id,
                competitor: competitor.id,
                articleName,
            })
            .post()
            .finally(() => (betting.value = false));
        guestStore.movements.unshift(result.movement);
        return result;
    }

    async function openRace(occurrence) {
        const result = await api("occurrences.open")
            .params({ occurrence: occurrence.id })
            .post();
        await fetchGames();
        return result;
    }

    async function startRace(occurrence) {
        const result = await api("occurrences.start")
            .params({ occurrence: occurrence.id })
            .post();
        await fetchGames();
        return result;
    }

    async function setRanking(occurrence, ranking) {
        const result = await api("occurrences.setRanking")
            .params({ occurrence: occurrence.id })
            .data({ ranking })
            .post();
        await fetchGames();
        return result;
    }

    return {
        games,
        fetchingGames,
        fetchGames,
        fetchGamesIfNeeded,
        byName,
        marbleRace,
        betOn,
        betting,
        openRace,
        startRace,
        setRanking,
    };
});
