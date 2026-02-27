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
import { computed } from "vue";
import { useMainStore } from "@/stores/main";

const props = defineProps({
    occ: Object,
});

const router = useRouter();

const mainStore = useMainStore();

const disabled = computed(
    () =>
        !mainStore.user && ["initial", "cancelled"].includes(props.occ.status),
);
const buttonText = computed(() => {
    return (
        {
            initial: "Trop tôt",
            open: "Parier",
            started: "En cours",
            ranked: "Voir les résultats",
            cancelled: "Annulé",
        }[props.occ.status] || "Voir"
    );
});

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
                    <div>Départ à {{ occ.start_at_time }}</div>
                    <div v-if="occ.status === 'initial'">
                        Ouverture des paris à {{ occ.bets_open_at_time }}
                    </div>
                </ItemDescription>
            </div>
        </ItemContent>
        <ItemActions>
            <Button :disabled @click="goToOcc">
                {{ buttonText }}
            </Button>
        </ItemActions>
    </Item>
</template>
