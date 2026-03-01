<script setup>
import {
    Item,
    ItemActions,
    ItemContent,
    ItemGroup,
    ItemMedia,
    ItemSeparator,
    ItemTitle,
    ItemDescription,
} from "@/components/ui/item";
import { computed } from "vue";
import Badge from "./ui/badge/Badge.vue";

const props = defineProps({
    competitors: Array,
    ranking: Object,
    showBettors: Boolean,
});

const emits = defineEmits(["item-click"]);

const sortedCompetitors = computed(() => {
    if (props.ranking) {
        return props.competitors
            .map((c) => {
                const rank = props.ranking[c.id] ?? Infinity;
                return { ...c, rank };
            })
            .sort((a, b) => a.rank - b.rank);
    }
    return props.competitors;
});
</script>

<template>
    <ItemGroup>
        <ItemSeparator />
        <template v-for="competitor in sortedCompetitors" :key="competitor.id">
            <Item>
                <div v-if="competitor.rank" class="w-6">
                    <span v-if="competitor.rank === Infinity"> DNF </span>
                    <Badge v-else>
                        {{ competitor.rank }}
                    </Badge>
                </div>
                <ItemMedia @click="emits('item-click', competitor)">
                    <img class="size-12 rounded" :src="competitor.image_url" />
                </ItemMedia>
                <ItemContent>
                    <div>
                        <ItemTitle>{{ competitor.name }}</ItemTitle>
                        <template v-if="showBettors">
                            <template v-if="competitor.bettors.length < 10">
                                <ItemDescription
                                    v-for="bettor in competitor.bettors"
                                >
                                    {{ bettor }}
                                </ItemDescription>
                            </template>
                            <ItemDescription
                                v-else-if="competitor.bettors.length"
                            >
                                {{ competitor.bettors.length }} paris
                            </ItemDescription>
                        </template>
                    </div>
                </ItemContent>
                <ItemActions>
                    <slot name="actions" :competitor="competitor"></slot>
                </ItemActions>
            </Item>
            <ItemSeparator />
        </template>
    </ItemGroup>
</template>
