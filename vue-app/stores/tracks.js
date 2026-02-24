import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { groupBy, keyBy } from "lodash-es";
import { watchDebounced } from "@vueuse/core";
import { api } from "@/api";

export const useTracksStore = defineStore("tracks", () => {
    const searchQuery = ref("");

    const searchResults = ref(null);

    async function searchTracks() {
        if (!searchQuery.value) {
            searchResults.value = null;
            return;
        }
        searchResults.value = await api("spotify.search-tracks")
            .params({ q: searchQuery.value })
            .get();
    }

    watchDebounced(searchQuery, searchTracks, { debounce: 500 });

    async function searchMore() {
        const data = await api("spotify.search-tracks")
            .params({
                q: searchQuery.value,
                offset: searchResults.value.offset + 10,
            })
            .get();
        searchResults.value = {
            ...data,
            items: searchResults.value.items.concat(data.items),
        };
    }

    return {
        searchQuery,
        searchResults,
        searchTracks,
        searchMore,
    };
});
