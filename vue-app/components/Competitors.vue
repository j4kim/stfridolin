<script setup>
import {
    Item,
    ItemActions,
    ItemContent,
    ItemGroup,
    ItemMedia,
    ItemSeparator,
    ItemTitle,
} from "@/components/ui/item";

const props = defineProps({
    competitors: Array,
});

const emits = defineEmits(["item-click"]);
</script>

<template>
    <ItemGroup>
        <ItemSeparator />
        <template v-for="competitor in props.competitors" :key="competitor.id">
            <Item>
                <ItemMedia @click="emits('item-click', competitor)">
                    <img class="size-12 rounded" :src="competitor.image_url" />
                </ItemMedia>
                <ItemContent>
                    <ItemTitle>{{ competitor.name }}</ItemTitle>
                </ItemContent>
                <ItemActions>
                    <slot name="actions" :competitor="competitor"></slot>
                </ItemActions>
            </Item>
            <ItemSeparator />
        </template>
    </ItemGroup>
</template>
