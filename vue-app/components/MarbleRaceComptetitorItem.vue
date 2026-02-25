<script setup>
import {
    Item,
    ItemActions,
    ItemContent,
    ItemMedia,
    ItemTitle,
} from "@/components/ui/item";
import ValidationDrawer from "@/components/ValidationDrawer.vue";
import { useGamesStore } from "@/stores/games";

const props = defineProps({
    competitor: {
        type: Object,
        required: true,
    },
});

const gamesStore = useGamesStore();
</script>

<template>
    <Item>
        <ItemMedia>
            <img class="size-12 rounded" :src="competitor.image_url" />
        </ItemMedia>
        <ItemContent>
            <ItemTitle>{{ competitor.name }}</ItemTitle>
        </ItemContent>
        <ItemActions>
            <ValidationDrawer
                trigger="Choisir"
                :title="`Parier sur ${competitor.name}&nbsp;?`"
                :action="() => gamesStore.betOn(competitor)"
                articleName="bet-on-a-marble"
                :disabled="false"
            ></ValidationDrawer>
        </ItemActions>
    </Item>
</template>
