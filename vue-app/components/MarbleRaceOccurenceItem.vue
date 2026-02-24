<script setup>
import Button from "@/components/ui/button/Button.vue";
import {
    Item,
    ItemActions,
    ItemContent,
    ItemDescription,
    ItemTitle,
} from "@/components/ui/item";

defineProps({
    occ: Object,
});

function time(datetime) {
    return new Date(datetime).toLocaleTimeString([], {
        timeStyle: "short",
    });
}
</script>

<template>
    <Item>
        <ItemContent>
            <div>
                <ItemTitle>{{ occ.title }}</ItemTitle>
                <ItemDescription>
                    De
                    {{ time(occ.start_at) }}
                    à
                    {{ time(occ.end_at) }}
                </ItemDescription>
            </div>
        </ItemContent>
        <ItemActions>
            <Button disabled> C'est trop tôt </Button>
        </ItemActions>
    </Item>
</template>
