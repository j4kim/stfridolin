import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { groupBy, keyBy } from "lodash-es";
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

    const byName = computed(() => keyBy(games.value, "name"));

    return {
        games,
        fetchingGames,
        fetchGames,
        byName,
    };
});
