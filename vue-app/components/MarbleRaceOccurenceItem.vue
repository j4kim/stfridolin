<script setup>
import Button from "@/components/ui/button/Button.vue";
import {
    Item,
    ItemActions,
    ItemContent,
    ItemDescription,
    ItemTitle,
} from "@/components/ui/item";
import { useRouter } from "vue-router";

const props = defineProps({
    occ: Object,
});

const router = useRouter();

function goToOcc() {
    router.push({
        name: "marble-race-occurrence",
        params: { occId: props.occ.id },
    });
}
</script>

<template>
    <Item>
        <ItemContent>
            <div>
                <ItemTitle>{{ occ.title }}</ItemTitle>
                <ItemDescription>
                    Départ à {{ occ.start_at_time }}<br />
                    Ouverture des paris à {{ occ.bets_open_at_time }}
                </ItemDescription>
            </div>
        </ItemContent>
        <ItemActions>
            <Button v-if="occ.status === 'open'" @click="goToOcc">
                Parier
            </Button>
            <Button v-else-if="occ.status === 'closed'" @click="goToOcc">
                Voir les résultats
            </Button>
            <Button v-else disabled> Trop tôt </Button>
        </ItemActions>
    </Item>
</template>
