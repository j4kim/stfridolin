import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { watchDebounced } from "@vueuse/core";
import { api } from "@/api";

export const useTracksStore = defineStore("tracks", () => {
    const searchQuery = ref("");
    const searching = ref(false);
    const searchingMore = ref(false);
    const searchResults = ref(null);

    async function searchTracks() {
        if (!searchQuery.value) {
            searchResults.value = null;
            return;
        }
        searching.value = true;
        searchResults.value = await api("spotify.search-tracks")
            .params({ q: searchQuery.value })
            .get()
            .finally(() => (searching.value = false));
    }

    watchDebounced(searchQuery, searchTracks, { debounce: 500 });

    async function searchMore() {
        searchingMore.value = true;
        const data = await api("spotify.search-tracks")
            .params({
                q: searchQuery.value,
                offset: searchResults.value.offset + 10,
            })
            .get()
            .finally(() => (searchingMore.value = false));
        searchResults.value = {
            ...data,
            items: searchResults.value.items.concat(data.items),
        };
    }

    const queueTracks = ref([]);
    const fetchingQueue = ref(false);

    async function fetchQueue() {
        fetchingQueue.value = true;
        queueTracks.value = await api("tracks.queue")
            .get()
            .finally(() => (fetchingQueue.value = false));
    }

    const guestTracks = computed(() =>
        queueTracks.value.filter((t) => t.proposed_by),
    );

    const backupTracks = computed(() =>
        queueTracks.value.filter((t) => !t.proposed_by),
    );

    async function add(track) {
        const response = await api("tracks.store")
            .params(track.spotify_uri)
            .post();
        queueTracks.value.push(response.track);
        return response;
    }

    function inQueue(track) {
        return guestTracks.value.some(
            (t) => t.spotify_uri === track.spotify_uri,
        );
    }

    return {
        searchQuery,
        searching,
        searchingMore,
        searchResults,
        searchTracks,
        searchMore,
        queueTracks,
        fetchingQueue,
        fetchQueue,
        guestTracks,
        backupTracks,
        add,
        inQueue,
    };
});
