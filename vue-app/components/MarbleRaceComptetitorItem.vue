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
import { useRoute } from "vue-router";

const props = defineProps({
    competitor: {
        type: Object,
        required: true,
    },
});

const route = useRoute();

const gamesStore = useGamesStore();

async function bet() {
    console.log(
        "Bet on",
        props.competitor.name,
        "in occurrence",
        props.competitor.pivot.occurrence_id,
    );
}
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
                :action="() => bet()"
                articleName="bet-on-a-marble"
                :disabled="false"
            ></ValidationDrawer>
        </ItemActions>
    </Item>
</template>
