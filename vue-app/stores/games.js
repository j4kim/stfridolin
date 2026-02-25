import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { keyBy } from "lodash-es";
import { api } from "@/api";

export const useGamesStore = defineStore("games", () => {
    const games = ref([]);
    const fetchingGames = ref(false);

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
        const result = await api("occurrences.bet")
            .params({
                occurrence: competitor.pivot.occurrence_id,
                competitor: competitor.id,
                articleName,
            })
            .post();
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
    };
});
