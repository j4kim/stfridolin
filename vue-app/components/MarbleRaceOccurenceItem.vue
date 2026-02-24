<script setup>
import Button from "@/components/ui/button/Button.vue";
import {
    Item,
    ItemActions,
    ItemContent,
    ItemDescription,
    ItemTitle,
} from "@/components/ui/item";
import dayjs from "dayjs";
import { computed } from "vue";

const props = defineProps({
    occ: Object,
});

const startAt = computed(() => dayjs(props.occ.start_at).format("HH:mm"));

const betsOpenAt = computed(() =>
    dayjs(props.occ.start_at).subtract(30, "minutes").format("HH:mm"),
);
</script>

<template>
    <Item>
        <ItemContent>
            <div>
                <ItemTitle>{{ occ.title }}</ItemTitle>
                <ItemDescription>
                    Départ à {{ startAt }}<br />
                    Ouverture des paris à {{ betsOpenAt }}
                </ItemDescription>
            </div>
        </ItemContent>
        <ItemActions>
            <Button disabled>Trop tôt</Button>
        </ItemActions>
    </Item>
</template>
