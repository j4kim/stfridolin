import { defineStore } from "pinia";
import { computed, ref, watch } from "vue";
import { keyBy, merge } from "lodash-es";
import { api } from "@/api";
import { useGuestStore } from "./guest";
import { pusher } from "@/broadcasting";

export const useGamesStore = defineStore("games", () => {
    const guestStore = useGuestStore();

    const games = ref(JSON.parse(document.body.dataset.games));

    const gameName = ref(null);

    const byName = computed(() => keyBy(games.value, "name"));

    const gameId = computed(() => byName.value[gameName.value]?.id);

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

    async function fetchOccurrence(occurrenceId, params = {}) {
        if (occurrence.value && occurrenceId != occurrence.value.id) {
            occurrence.value = null;
        }
        params.occurrence = occurrenceId;
        fetching.value = true;
        occurrence.value = await api("occurrences.get")
            .params(params)
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

    async function participate(occurrenceId, meta, articleName) {
        const result = await api("occurrences.participate")
            .params({ occurrence: occurrenceId })
            .data({ meta, articleName })
            .post();
        guestStore.movements.unshift(result.movement);
        return result;
    }

    async function finish(meta, occurrenceId) {
        const result = await api("occurrences.finish")
            .params({ occurrence: occurrenceId })
            .data({ meta })
            .post();
        return result;
    }

    watch(gameId, (newGameId, oldGameId) => {
        if (newGameId) {
            subscribeToGameChannel(newGameId);
        }
        if (oldGameId) {
            pusher.unsubscribe(`game-${oldGameId}`);
        }
    });

    function subscribeToGameChannel(gameId) {
        const channel = pusher.subscribe(`game-${gameId}`);

        channel.bind("OccurrenceUpdated", (data) => {
            if (occurrence.value?.id == data.model.id) {
                occurrence.value = merge(occurrence.value, data.model);
            }
            if (game.value?.occurrences) {
                const index = game.value.occurrences.findIndex(
                    (o) => o.id == data.model.id,
                );
                if (index > -1) {
                    game.value.occurrences[index] = data.model;
                }
            }
        });
    }

    return {
        games,
        game,
        gameName,
        gameId,
        occurrence,
        fetching,
        fetchGame,
        fetchOccurrence,
        betOn,
        betting,
        openRace,
        startRace,
        setRanking,
        participate,
        finish,
    };
});
