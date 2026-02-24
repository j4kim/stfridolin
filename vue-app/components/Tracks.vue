<script setup lang="ts">
import type { Track } from "@/types";
import {
    Item,
    ItemActions,
    ItemContent,
    ItemDescription,
    ItemGroup,
    ItemMedia,
    ItemSeparator,
    ItemTitle,
} from "./ui/item";

const props = defineProps<{
    tracks?: Track[];
}>();
</script>

<template>
    <ItemGroup v-if="tracks?.length">
        <ItemSeparator />
        <template v-for="(track, index) in tracks" :key="track.spotify_uri">
            <Item>
                <ItemMedia>
                    <img
                        class="size-10 rounded"
                        :src="track.img_thumbnail_url"
                    />
                </ItemMedia>
                <ItemContent>
                    <div>
                        <ItemTitle>{{ track.name }}</ItemTitle>
                        <ItemDescription>
                            {{ track.artist_name }}
                        </ItemDescription>
                    </div>
                </ItemContent>
                <ItemActions>
                    <slot :track="track" name="actions"></slot>
                </ItemActions>
            </Item>
            <ItemSeparator />
        </template>
        <slot name="after"></slot>
    </ItemGroup>
</template>
