<script setup lang="ts">
import { defineAsyncComponent, watch } from "vue";
import { useMainStore } from "./stores/main";
import FullPageLoading from "./components/FullPageLoading.vue";
import { useWindowFocus,  } from '@vueuse/core'
import { useFightStore } from "./stores/fight";
import { useGuestStore } from "./stores/guest";
import { useTracksStore } from "./stores/tracks";
import { useGamesStore } from "./stores/games";
import { useStorage } from "@vueuse/core";

const focused = useWindowFocus();

const mainStore = useMainStore();
const fightStore = useFightStore();
const guestStore = useGuestStore();
const trackStore = useTracksStore();
const gameStore = useGamesStore();

const UseToaster = defineAsyncComponent({
    loader: () => import("@/components/UseToaster.vue"),
    loadingComponent: FullPageLoading,
    delay: 100,
});

watch(focused, (newFocused) => {
    if(newFocused){
        //Guest
        let guest = useStorage("guest", {});
        if(guest.value.key){
            guestStore.fetchGuest(guest.value.key)
        //Jukeboxe fight
        fightStore.fetchCurrentFight()
        //Queue
        trackStore.fetchQueue()
        //Game occurences
        gameStore.fetchAllGames();
        }
    }
})

</script>

<template>
    <UseToaster>
        <FullPageLoading v-if="mainStore.isNavigating" />
        <RouterView v-else></RouterView>
    </UseToaster>
</template>
